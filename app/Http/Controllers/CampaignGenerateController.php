<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdCampaign;
use App\Models\Campign;
use App\Models\CountryCampaign;
use App\Models\Setting;
use App\Models\GenerateHeadLines;
use Illuminate\Support\Facades\Http;

class CampaignGenerateController extends Controller
{
    //create cmapign using facebook ads api

    protected $accessToken;
    protected $accountId;

    public function __construct()
    {
        $this->accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $this->accountId = 'act_1440720373248918';
    }


    public function AccountList(Request $request , $id) {
        $adscampaign = AdCampaign::all(); 
        $defaultCampaignId = $request->campaing_id ?: AdCampaign::first()->id; // Default to the first campaign if none selected
        $defaultCampaign = $adscampaign->firstWhere('id', $defaultCampaignId);
        $adAccounts  = AdCampaign::where('id' , $defaultCampaignId)->get();
        $campaign = Campign::where('id' , $id)->first();
        return view('campign.campiagnaccount' , compact('adscampaign' , 'defaultCampaignId' , 'campaign'));
    }

    public function getPixelsByAccount($accountId)
    {
        // Fetch pixels associated with the given account ID
        $pixels = AdCampaign::where('account_id', $accountId)->get();
        // Decode the pixel_id JSON field
        $decodedPixels = [];
        foreach ($pixels as $pixel) {
            $decodedPixels = array_merge($decodedPixels, json_decode($pixel->pixel_id, true));
        }

        return response()->json($decodedPixels);
    }


    public function CampaignAdsCreate(Request $request, $id)
    {
        ini_set('max_execution_time', 6000);
        try {
            $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
            
            $campaign = Campign::where('id', $id)->first();
            $cmapignID = $campaign->id;
            $campaignNames = json_decode($campaign->topic_campaign_name);
            
            $groups = Setting::select('name')->get()->pluck('name')->toArray();
            $countries = CountryCampaign::select('name', 'group')->get();
            
            $result = array_fill_keys($groups, []);
            foreach ($countries as $country) {
                $groupKey = array_search(strtolower($country->group), array_map('strtolower', $groups));
                if ($groupKey !== false) {
                    $result[$groups[$groupKey]][] = $country->name;
                } else {
                    $result['others'][] = $country->name;
                }
            }
            $result = array_filter($result);

            $imageRecords = GenerateHeadLines::select('images' , 'hashes')->where('campaign_id', $id)->get();

            $allImagesUploaded = true;
            foreach ($imageRecords as $record) {
                $images = json_decode($record->hashes, true);
                if ($images === null || empty($images)) {
                    return redirect()->route('index-campaign')->with('error', __('First upload images hashes for specific language'));
                }
            }

            // dd($allImagesUploaded);

            $url = "https://graph.facebook.com/v20.0/{$accountId}/campaigns";
            $createdCampaigns = [];
            foreach ($campaignNames as $campaignName) {
                $response = Http::post($url, [
                    'access_token' => $this->accessToken,
                    'name' => $campaignName,
                    'objective' => 'OUTCOME_SALES',
                    'special_ad_categories' => 'NONE',
                    'status' => 'PAUSED'
                ]);
            
                $campaign = $response->json();
                
                if (isset($campaign['error'])) {
                    $errorMessage = $campaign['error']['message'] ?? 'An unknown error occurred';
                    \Log::error("Failed to create campaign: $campaignName. Error: $errorMessage");
                    return redirect()->route('index-campaign')->with('error', $errorMessage);
                }

                $campaignId = $campaign['id'] ?? null;
                // hudfhdr-t1e-fb-ads
                if ($campaignId) {
                    $createdCampaigns[] = [
                        'name' => $campaignName,
                        'id' => $campaignId
                    ];
                } else {
                    $errorMessage = __('Failed to create campaign: ') . $campaignName;
                    \Log::error($errorMessage);
                    return redirect()->route('index-campaign')->with('error', $errorMessage);
                }
            }


             // Create Ad Sets for each group
             foreach ($createdCampaigns as $createdCampaign) {
                $campaignName = strtolower($createdCampaign['name']);
                foreach ($result as $group => $countriesInGroup) {
                    // if (strtolower($group) === $campaignName) {
                    $position = strpos(strtolower($campaignName), strtolower($group));
                    if ($position !== false) {
                        foreach ($countriesInGroup as $country) {
                          $adSetId = $this->createAdSetForGroup($createdCampaign['id'], $group, $country, $request);
                            if ($adSetId) {
                                $this->createAdsForAdSet($adSetId, $country, $request , $cmapignID);
                            }
                        }
                    }
                }
            }
    
            return response()->json([
                'campaigns' => $createdCampaigns,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function fetchAccountDetails($request)
    // {
    //     $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';

    //     $response = Http::get("https://graph.facebook.com/v20.0/{$accountId}?fields=default_dsa_beneficiary&access_token={$this->accessToken}");

    //     if ($response->failed()) {
    //         \Log::error("Failed to fetch account details", ['response' => $response->json()]);
    //         return null;
    //     }

    //     return $response->json();
    // }

    protected function createAdSetForGroup($campaignId, $group, $country, $request)
    {
        // Determine the account ID
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
        
        // Fetch account details
        // $accountDetails = $this->fetchAccountDetails($request);
        $accountDetails = AdCampaign::where('act_account_id' , $accountId)->first();
        if (!$accountDetails) {
            \Log::error("Account details not found");
            return;
        }
        
        // Create Ad Set
        $url = "https://graph.facebook.com/v14.0/{$accountId}/adsets";
        // $pixelId = '506000408596077'; // Replace with your actual pixel ID
        $pixelId = $request->pixel_id;
        
        // Fetch country code
        $countryData = CountryCampaign::select('short_code')->where('name', $country)->first();

        if (!$countryData) {
            \Log::error("Country code not found for country: $country");
            return; // Skip creating Ad Set if country code is not found
        }

        $countryCode = $countryData->short_code;
        $dsaBeneficiary = $accountDetails->default_dsa_beneficiary ?? null;
         // Define European countries
        $europeanCountries = [
            'Finland', 'Austria', 'France', 'Germany', 'Greece', 'Ireland', 'Italy', 'Luxembourg', 'Netherlands', 'Poland', 'Portugal',
            'Romania', 'Spain','Sweden',
        ];

        // Prepare request data
        $adSetData = [
            'access_token' => $this->accessToken,
            'name' => $country, // Use country for ad set name
            'optimization_goal' => 'OFFSITE_CONVERSIONS',
            'billing_event' => 'IMPRESSIONS',
            'bid_amount' => '10000',
            'daily_budget' => '10000',
            'campaign_id' => $campaignId,
            'start_time' => now()->toIso8601String(),
            'status' => 'PAUSED',
            'targeting' => [
                'geo_locations' => [
                    'countries' => [$countryCode] // Use the actual country code
                ],
                'publisher_platforms' => ['facebook', 'instagram'],
            ],
            'conversion_specs' => [
                'conversion_location' => 'website',
                'conversion_event' => 'PURCHASE'
            ],
            'promoted_object' => [
                'pixel_id' => $pixelId,
                'custom_event_type' => 'PURCHASE'
            ],
        ];

        // Add beneficiary information if the country is in the European list
        if (in_array($country, $europeanCountries)) {
            $adSetData['dsa_beneficiary'] = $dsaBeneficiary;
        }

        $response = Http::post($url, $adSetData);

        $res = $response->json();

        // Log response or errors
        if ($response->failed()) {
            \Log::error("Failed to create Ad Set for country: $country", ['response' => $res]);
        } else {
            \Log::info("Ad Set created successfully for country: $country", ['response' => $res]);
        }

        return $res['id'] ?? null;
    }

    protected function createAdsForAdSet($adSetId, $country, $request , $cmapignID)
    {
        $accountId = $request->account_id;
        $creativeData = $this->getCreativeDataForCountry($country , $cmapignID , $accountId);

        // Create Ad Creative
        $creativeResponse = $this->createAdCreative($creativeData , $request , $cmapignID);
        $creative_id = $creativeResponse['id'] ?? null;

        if (!$creative_id) {
            \Log::error("Creative ID not found for country: $country");
            return;
        }

        // Create Ad
        $adResponse = $this->createAd($adSetId, $creative_id , $request , $country);
        if ($adResponse->successful()) {
            \Log::info("Ad created successfully for country: $country");
        } else {
            \Log::error("Failed to create Ad for country: $country");
        }
    }

    protected function getCreativeDataForCountry($country , $cmapignID , $accountId)
    {
        $account = $accountId ? 'act_' . $accountId : 'act_1440720373248918';
        $account_id = AdCampaign::where('act_account_id' , $account)->first();
        $country_id = CountryCampaign::where('name' , $country)->first();
        // $Data = GenerateHeadlines::where('campaign_id' , $cmapignID)->where('language' , $country_id->language)->where('account_id' , $account_id->id)->first();
        $Data = GenerateHeadLines::where('campaign_id' , $cmapignID)->where('language' , $country_id->language)->first();
        return [
            'headline' => $Data->headline ?? "",
            'primary_text' => $Data->primary_text ?? "",
            'description' => $Data->description ?? "",
            'images' => json_decode($Data->images, true), // Decode JSON to array
            'hashes' => json_decode($Data->hashes, true) 
        ];
    }

    protected function createAdCreative($data, $request, $cmapignID)
    {
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
        $campaign = Campign::where('id', $cmapignID)->first();
        $display_name = str_replace(" ", "-", $campaign->topic);
        $display_link = "https://{$display_name}.com";
        $headline = $data['headline'] ?? "It's a headline";
        $tracking_url =  "https://flarequick.com/cf/r/669a9bc816aab80012aac85e?ad_id={{ad.id}}&adset_id={{adset.id}}&campaign_id={{campaign.id}}&ad_name={{ad.name}}&adset_name={{adset.name}}&campaign_name={{campaign.name}}&source={{site_source_name}}&placement={{placement}}";
        // Create carousel items
        $carouselItems = [];
        foreach ($data['hashes'] as $index => $imageUrl) {
            // $imageHash = $this->uploadImage($imageUrl);
            $imageHash = $imageUrl;
            if ($imageHash) {
                $carouselItems[] = [
                    'link' => $display_link,
                    'message' => $data['primary_text'],
                    'image_hash' => $imageHash,
                    'title' => $headline,
                    'name' => $headline, // 'name' is used for the headline
                    'description' => $data['description'],
                ];
            }
        }

        $url = "https://graph.facebook.com/v20.0/{$accountId}/adcreatives";

        $object_story_spec = [
            'page_id' => '290310557504951',
            'link_data' => [
                'message' => $data['primary_text'],
                'link' => $display_link, // Ensure this is included
                'name' => $headline, // Overall headline for the ad
                'call_to_action' => [
                    'type' => 'LEARN_MORE',
                    'value' => ['link' => $display_link]
                ],
                'child_attachments' => $carouselItems,
            ]
        ];

        $degrees_of_freedom_spec = [
            "creative_features_spec" => [
                "standard_enhancements" => [
                    "enroll_status" => "OPT_IN"
                ]
            ]
        ];

        // Convert the object_story_spec to JSON manually to ensure proper encoding
        $response = Http::post($url, [
            'access_token' => $this->accessToken,
            'name' => $data['headline'],
            'object_story_spec' => json_encode($object_story_spec, JSON_UNESCAPED_SLASHES),
            'degrees_of_freedom_spec' => json_encode($degrees_of_freedom_spec),
            'status' => 'PAUSED',
        ]);

        // Check the response
        if ($response->failed()) {
            \Log::error("Failed to create carousel ad creative", ['response' => $response]);
            return null;
        }

        return $response->json();
    }

    // protected function createAdCreative($data , $request , $cmapignID)
    // {
    //     $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
    //     // $image_hash = $this->uploadImage($data['image']);
    //     $campaign = Campign::where('id', $cmapignID)->first();
    //     $display_name = str_replace(" " , "-" , $campaign->topic);
    //     $display_track = 'tracked';
    //     $display_link = "https://{$display_name}.com";
    //     $tracking_url = "https://{$display_name}dd.com";
    //        // Create carousel items
    //        $carouselItems = [];
    //        foreach ($data['images'] as $index => $imageUrl) {
    //            $imageHash = $this->uploadImage($imageUrl);
    //            if ($imageHash) {
    //                $carouselItems[] = [
    //                    'link' => $display_link,
    //                    'message' => $data['primary_text'],
    //                    'image_hash' => $imageHash,
    //                    'title' => $data['headline'],
    //                    'description' => $data['description'],
    //                ];
    //            }
    //        }
    //     $url = "https://graph.facebook.com/v20.0/{$accountId}/adcreatives";
        
        
    //     $object_story_spec = [
    //         'page_id' => '290310557504951',
    //         'link_data' => [
    //                 'message' => $data['primary_text'],
    //                 'link' => $display_link, // Ensure this is included
    //                 'call_to_action' => [
    //                     'type' => 'LEARN_MORE',
    //                     'value' => ['link' => $display_link]
    //                 ],
    //                 'child_attachments' => $carouselItems
    //             ]
    //     ];
    
    //     $degrees_of_freedom_spec = [
    //         "creative_features_spec" => [
    //             "standard_enhancements" => [
    //                 "enroll_status" => "OPT_IN"
    //             ]
    //         ]
    //     ];
    //     // Convert the object_story_spec to JSON manually to ensure proper encoding
    //     $response = Http::post($url, [
    //         'access_token' => $this->accessToken,
    //        'name' => 'Carousel Ad Creative - ' . time(),
    //         'object_story_spec' => json_encode($object_story_spec, JSON_UNESCAPED_SLASHES),
    //         'degrees_of_freedom_spec' => json_encode($degrees_of_freedom_spec),
    //         'status' => 'PAUSED',
    //     ]);

       
    //     // Check the response
    //     if ($response->failed()) {
    //         \Log::error("Failed to create carousel ad creative", ['response' => $response]);
    //         return null;
    //     }

    //     return $response->json();
    // }

    protected function createAd($adSetId, $creative_id , $request , $country)
    {
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
        $country_id = CountryCampaign::where('name' , $country)->first();
        $url = "https://graph.facebook.com/v14.0/{$accountId}/ads";

        
        return Http::post($url, [
            'access_token' => $this->accessToken,
            'name' => $country_id->language . '-' .$country_id->short_code,
            'adset_id' => $adSetId,
            'creative' => [
                'creative_id' => $creative_id
            ],
            'status' => 'PAUSED',
        ]);
    }

    // protected function uploadImage($imageUrl)
    // {
    //     // Download the image
    //     $tempImage = tempnam(sys_get_temp_dir(), 'img');
    //     file_put_contents($tempImage, file_get_contents($imageUrl));
    
    //     $url = "https://graph.facebook.com/v14.0/{$this->accountId}/adimages";
        
    //     // Upload the image
    //     $response = Http::attach(
    //         'source', fopen($tempImage, 'r'), basename($imageUrl)
    //     )->post($url, [
    //         'access_token' => $this->accessToken,
    //     ]);
        
    //     // Delete the temporary file
    //     unlink($tempImage);
        
    //     $responseData = $response->json();
    
    //     // Check the response
    //     if ($response->failed()) {
    //         \Log::error("Failed to upload image", ['response' => $responseData]);
    //         return null;
    //     }
    
    //     // Extract and return the image hash
    //     $imageKey = basename($imageUrl);
    //     return $responseData['images'][$imageKey]['hash'] ?? null;
    // }
    




    // protected function createAdSet($campaignId, $request,$language)
    // {
    //     $url = "https://graph.facebook.com/v14.0/{$this->accountId}/adsets";
    //     $adset_name = 'New Sales Campaign Ad set- ' . time();
    //     $pixelId = '551119010761776';
    //     return Http::post($url, [
    //         'access_token' => $this->accessToken,
    //         'name' => $adset_name,
    //         'optimization_goal' => 'OFFSITE_CONVERSIONS',
    //         'billing_event' => 'IMPRESSIONS',
    //         'bid_amount' => '10000',
    //         'daily_budget' => '10000',
    //         'campaign_id' => $campaignId,
    //         'start_time' => now()->toIso8601String(),
    //         'status' => 'PAUSED',
    //         'targeting' => [
    //             'geo_locations' => [
    //                 'countries' => ['US'] // Example: Target users in the US
    //             ],
    //             'publisher_platforms' => ['facebook', 'instagram'],
    //             // Additional targeting parameters can be added here
    //         ],
    //         'conversion_specs' => [
    //           'conversion_location' => 'website',
    //           'conversion_event' => 'PURCHASE' 
    //         ],
    //         'promoted_object' => [
    //             'pixel_id' => $pixelId,
    //             'custom_event_type' => 'PURCHASE'
    //         ],
    //     ]);
    // }

    // protected function createAds($adSetId, $request)
    // {
    //     $ad_name = 'New Sales Campaign Ad- ' . time();
    //     $url = "https://graph.facebook.com/v14.0/{$this->accountId}/ads";

    //     return Http::post($url, [
    //         'access_token' => $this->accessToken,
    //         'name' => $ad_name,
    //         'adset_id' => $adSetId,
    //         'creative' => [
    //             'creative_id' => $request->creative_id,
    //         ],
    //         'status' => 'PAUSED'
    //     ]);
    // }


    // protected function uploadImage($imageFile)
    // {
    //     $url = "https://graph.facebook.com/v14.0/{$this->accountId}/adimages";
    //     $image_path = $imageFile->getRealPath(); // Path to the uploaded image file
    //     $response = Http::attach(
    //         'source', fopen($imageFile->getRealPath(), 'r'), 'image.jpg'
    //         )->post($url, [
    //             'access_token' => $this->accessToken,
    //         ]);
    //         $responseData = $response->json();
    //         dd($responseData);
    //         $imageKey = 'image.jpg'; 
    //     return $responseData['images'][$imageKey]['hash'] ?? null;
    // }


    // protected function createAdCreatives(Request $request)
    // {
    //     $imageFile = $request->file('image');
    //     $image_hash = $this->uploadImage($imageFile);
    
    //     $url = "https://graph.facebook.com/v20.0/{$this->accountId}/adcreatives";
    //     $primary_text = "hetdsp";
    //     $headline = "hetdsp";
    //     $description = "https://propworth.net/";
    //     $call_to_action = "LEARN_MORE";
    //     $url_tags = "https://example.com/url";
    //     $page_id = $request->facebook_page;
    
    //     $object_story_spec = [
    //         'page_id' => $page_id,
    //         'link_data' => [
    //             'message' => $primary_text,
    //             'link' => $description,
    //             'caption' => $description,
    //             'image_hash' => $image_hash,
    //             'call_to_action' => [
    //                 'type' => $call_to_action,
    //                 'value' => [
    //                     'link' => $url_tags,
    //                 ],
    //             ],
    //         ]
    //     ];
    
    //     $degrees_of_freedom_spec = [
    //         "creative_features_spec" => [
    //             "standard_enhancements" => [
    //                 "enroll_status" => "OPT_IN"
    //             ]
    //         ]
    //     ];
    //     // Convert the object_story_spec to JSON manually to ensure proper encoding
    //     $response = Http::post($url, [
    //         'access_token' => $this->accessToken,
    //         'name' => 'ADs Creative',
    //         'object_story_spec' => json_encode($object_story_spec, JSON_UNESCAPED_SLASHES),
    //         'degrees_of_freedom_spec' => json_encode($degrees_of_freedom_spec),
    //         'status' => 'PAUSED',
    //     ]);
    //     return $response->json();
    // }
    
}
