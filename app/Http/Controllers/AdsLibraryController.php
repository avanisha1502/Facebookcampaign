<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CountryCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdsLibraryController extends Controller
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = env('FACEBOOK_ACCESS_TOKEN');
    }
    public function index()
    {
        // Fetch country data from the Country model
        // $countries = Country::all(); // Adjust query if needed, e.g., adding sorting
        $countries = CountryCampaign::get();

        // Pass the countries to the view
        return view('ads_library.index', compact('countries'));
    }


    public function fetchAds(Request $request)
    {
        $url = "https://graph.facebook.com/v20.0/ads_archive";
        $afterCursor = $request->input('after', null);

        $fields = [
            'id',
            'page_name',
            'ad_snapshot_url',
            'ad_creative_bodies',
            'ad_creative_link_titles',
            'ad_creative_link_captions',
        ];

        $country = $request->query('ad_reached_countries');
        $adActiveStatus = $request->query('ad_active_status', 'ALL');
        $adType = $request->query('ad_type', 'ALL');
        $mediaType = $request->query('media_type', 'ALL');
        $publisherPlatforms = $request->query('publisher_platforms');
        $searchTerms = $request->query('search_terms');
    
        $queryParams = [
            'access_token' => $this->accessToken,
            'ad_reached_countries' => $request->input('ad_reached_countries', [$country]),
            'ad_active_status' => $adActiveStatus,
            'ad_type' => $adType,
            'media_type' => $mediaType,
            'publisher_platforms' => $publisherPlatforms,
            'search_terms' => $searchTerms,
            'limit' => 8,
            'fields' => implode(',', $fields),
        ];

        if ($afterCursor) {
            $queryParams['after'] = $afterCursor;
        }

        $response = Http::get($url, $queryParams);

        if ($response->successful()) {
            $campaign = $response->json();
            $enhancedAds = $this->enhanceAdsWithImages($campaign['data']);

            return response()->json([
                'ads' => $enhancedAds,
                'paging' => $campaign['paging'] ?? null,
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch ads from Facebook Ads Library API.',
                'details' => $response->json(),
            ], $response->status());
        }
    }

    private function enhanceAdsWithImages($ads)
    {
        foreach ($ads as &$ad) {
            if (isset($ad['ad_snapshot_url'])) {
                $ad['extracted_images'] = $this->extractImagesFromSnapshot($ad['ad_snapshot_url']);
            }
        }

        return $ads;     
    }

    private function extractImagesFromSnapshot($snapshotUrl)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->get($snapshotUrl);

        $html = $response->getBody()->getContents();

        // Regular expressions to find the URLs
        $imageUrlPattern = '/"resized_image_url":\s*"([^"]+)"/';
        $videoUrlPattern = '/"video_sd_url":\s*"([^"]+)"/';

        // Extracting the URLs using regex
        preg_match_all($imageUrlPattern, $html, $imageMatches);
        preg_match_all($videoUrlPattern, $html, $videoMatches);

        // Get all matches for each type
        $resizedImageUrls = $imageMatches[1] ?? [];
        $videoSdUrls = $videoMatches[1] ?? [];

        // Remove backslashes from the URLs
        $formattedImageUrls = array_map(function ($url) {
            return str_replace('\\', '', $url); // Remove backslashes
        }, $resizedImageUrls);

        $formattedVideoUrls = array_map(function ($url) {
            return str_replace('\\', '', $url); // Remove backslashes
        }, $videoSdUrls);

        return [
            'resized_image_urls' => $formattedImageUrls,
            'video_sd_urls' => $formattedVideoUrls,
        ];
    }
}
