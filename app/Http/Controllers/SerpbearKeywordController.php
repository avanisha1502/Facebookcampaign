<?php

namespace App\Http\Controllers;

use App\Models\SerpbearKeyword;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Domain;
use Google\Client as GoogleClient;
use Tda\GoogleSearchConsole\SearchConsole;
use Tda\GoogleSearchConsole\Period;
use Carbon\Carbon;
use App\Services\GoogleSearchConsoleService;
use Illuminate\Http\JsonResponse;
use Google\Service\Webmasters;
use Google_Service_Webmasters;
use Google_Service_Webmasters_SearchAnalyticsQueryRequest;
use App\Services\SerpApiService;
use Google\Service\Webmasters\SearchAnalyticsQueryRequest;
use App\Models\Country;

class SerpbearKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $serpApiService;

    public function __construct(SerpApiService $serpApiService)
    {
        $this->serpApiService = $serpApiService;
    }

    public function getKeywordSuggestionsPlan4521(Request $request): JsonResponse
    {
        $domain_id = Domain::find($request->domain_id);
        $domain = $domain_id->domain_name;
        $siteUrl = $domain; // Replace with your site URL
        $startDate = '2024-04-01'; // Adjust date range as needed
        $endDate = date('Y-m-d'); // Get today's date

        $analytics = $this->searchConsoleService->getSearchAnalytics($siteUrl, $startDate, $endDate);
        dd($analytics);
        return response()->json($analytics); // Return the search analytics data
    }


    public function index($domain_id)
    {
        $keyword_data = SerpbearKeyword::where('created_by' , \Auth::user()->id)->get();
        return view('keyword.index', compact('Keyword_data' , 'domain_id'));
    }

    // public function getDataFromSearchConsole(Request $request) {
    //     $domain_id = Domain::find($request->domain_id);
    //     $domain = $domain_id->domain_name;
    //     $keyword = $request->keyword;

    //     $client = new GoogleClient();
    //     $client->setAuthConfig(storage_path('app\credentials\serpbearkeywordplanner-9033f11034db.json'));
    //     $client->setScopes([Google_Service_Webmasters::WEBMASTERS_READONLY]);
    
    //     // Authenticate with Google API
    //     if ($client->isAccessTokenExpired()) {
    //         $client->fetchAccessTokenWithAssertion();
    //     }
    
    //     $service = new Google_Service_Webmasters($client);
    
    //     // Call the API to retrieve search query data for the domain
    //     $siteUrl = $domain;
    //     $startDate = now()->subDays(30)->toDateString(); // Start date for the data you want to retrieve
    //     $endDate = now()->subDays(2)->toDateString(); // End date for the data you want to retrieve
    //     $dimensions = ['query']; // Dimension to get search queries
    
    //     // Create a SearchAnalyticsQueryRequest object
    //     $request = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
    //     $request->setStartDate($startDate);
    //     $request->setEndDate($endDate);
    //     $request->setDimensions($dimensions);
    
    //     // Call the query method with the request object
    //     $data = $service->searchanalytics->query($siteUrl, $request);
    //     dd($data);
    //     // Filter the data by keyword
    //     $filteredData = [];
    //     foreach ($data->getRows() as $row) {
    //         // Check if the search query contains the keyword
    //         if (stripos($row->keys[0], $keyword) !== false) {
    //             $filteredData[] = $row;
    //         }
    //     }


    //     // $client = new GoogleClient();
    //     // $client->setAuthConfig(storage_path('app\credentials\serpbearkeywordplanner-9033f11034db.json'));
    //     // $client->setScopes([Google_Service_Webmasters::WEBMASTERS_READONLY]);
    
    //     // // Authenticate with Google API
    //     // if ($client->isAccessTokenExpired()) {
    //     //     $client->fetchAccessTokenWithAssertion();
    //     // }
    
    //     // $service = new Google_Service_Webmasters($client);
    
    //     // // Call the API to retrieve data
    //     // $siteUrl = $domain; // Dynamically set the domain
    //     // $startDate = now()->subDays(30)->toDateString();
    //     // $endDate = now()->subDays(2)->toDateString();
    //     // $dimensions = ['query']; // You can choose other dimensions like page, country, etc.
    //     // $options = ['startDate' => $startDate, 'endDate' => $endDate, 'dimensions' => $dimensions];
    //     // $data = $service->searchanalytics->query($siteUrl, $options);
    //     // dd($data);
    //     // Process the data
    //     // $data contains the response from Google Search Console API
    // }

    public function getKeywordSuggestionsPlan(Request $request)
    {
        $apiKey = 'ab92ef52-7ae8-4fed-9a7b-14907c9ce361';
        $keyword = $request->input('keyword');
        $domain_id = Domain::find($request->domain_id);
        $domain = $domain_id->domain_name;
        $country = $request->input('country');
        $jsonKeyFilePath = storage_path('app\credentials\serpbearkeywordplanner-9033f11034db.json');

        // Create a new Google Client object
        $client = new GoogleClient();

        // Set the credentials from the JSON key file
        $client->setAuthConfig($jsonKeyFilePath);

        // Set the scopes for the access token (Google Search Console API scope)
        $client->setScopes([
            'https://www.googleapis.com/auth/webmasters.readonly'
        ]);

        // Get the access token
        $accessToken = $client->fetchAccessTokenWithAssertion();

        $client = new Client();
        $bodyData = [
            'url' => $domain,
            'module' => 'GoogleScraper',
            'params' => [
                'query' => $keyword,
                'country' => $country
            ],
        ];
        $response = $client->request('POST', 'https://api.scrapingrobot.com/?token=' . $apiKey, [
            'body' => json_encode($bodyData),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $googlekeyword = new SerpbearKeyword();
        $googlekeyword->keyword = $data['result']['searchQuery']['term'];
        $googlekeyword->domain_id  = $domain_id->id;
        $googlekeyword->url   = $data['result']['url'];
        $googlekeyword->country = $country;
        $googlekeyword->created_by = \Auth::user()->id;
        $googlekeyword->save();

        return redirect()->back();
        // return view('keyword.index', compact('data' , 'domain_id'));

        // return response()->json($data);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($domain_id)
    {
        $domain_id = Domain::find($domain_id);
        $countries = Country::all();

        return view('keyword.create' , compact('countries' , 'domain_id'));
    }

    public function SerpApiCall(Request $request) {
        $domain_id = Domain::find($request->domain_id);
        $domain = $domain_id->id;

        $results = [];
        // Number of results per page
        $numPerPage = 100;

        // Start with the first page
        $page = 1;
        $apiKey = '03bcc35e470cd028ae84bc208e8cdcb4e6b1cfcfd4d1c5086dca7a5f22214cea'; // Retrieve your API key from configuration or .env
        // Loop to fetch all pages of results
        do {
            // Construct the query parameters for the API request
            $query = [
                "engine" => "google",
                "q" => $request->input('keyword'),
                "location" =>$request->input('country'),
                "hl" => "en",
                "gl" => "us",
                "google_domain" => "google.com",
                "num" => $numPerPage,
                "start" => ($page - 1) * $numPerPage + 1, // Calculate the start position for the current page
                "safe" => "active",
                "api_key" => $apiKey
            ];

            // Make the API request (you need to implement this part)
            // Example: $resultData = $this->serpApiService->search($query);
            // For demonstration purposes, let's assume $resultData is fetched from the API
            $resultData = $this->serpApiService->search($apiKey, $query);
            $organicResults = $resultData->organic_results;
            // Assuming $resultData contains the response data in JSON format
            // $resultData = json_decode('{"organic_results":[{"title":"Example Title 1","link":"http://example.com/page1"},{"title":"Example Title 2","link":"http://example.com/page2"}],"search_information":{"total_results":200}}', true);

            // Add the results from the current page to the overall results array
            $results = array_merge($results, $organicResults);

            // Increment the page counter for the next iteration
            $page++;
            $page_result = $resultData->search_information->total_results ?? "0";

        // Check if there are more pages of results to fetch
        } while (($page - 1) * $numPerPage < $page_result);

        $resultData = $this->serpApiService->search($apiKey, $query);
        $organicResults = $resultData->organic_results;  // Decode JSON string to array
        $domain_name = $domain_id->domain_name; // Replace with your domain

        $domainPosition = null;
        $parsedUrl = parse_url($domain_name);
        $domainName = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

        $domainNameMatches_Data = str_replace(['www.', '.com'], '', $domainName);

        foreach ($results as $index => $result) {
            $parsedLinkUrl = parse_url($result->link);
            $domainNameMatches = isset($parsedLinkUrl['host']) ? $parsedLinkUrl['host'] : '';
            // Compare the domain extracted from the link with the target domain
            if ($domainNameMatches == $domainName) {
                $domainPosition = $result->position; // Position starts from 1
                $result_link = $result->link;
                // Debugging statement
                // dd("Domain found at position: $domainPosition\n");
                break; // No need to continue searching once the domain is found
            }
        }
        $googlekeyword = new SerpbearKeyword();
        $googlekeyword->keyword = $resultData->search_parameters->q ;
        $googlekeyword->domain_id    = $domain;
        $googlekeyword->url          =    $result_link ?? NULL;
        // ?? $resultData->search_metadata->google_url ?? $resultData->search_metadata->raw_html_file
        $googlekeyword->country      = $resultData->search_parameters->location_used;
        $googlekeyword->total_search = $resultData->search_information->total_results ?? null;
        $googlekeyword->organic_results  = json_encode($results);
        $googlekeyword->device  = $resultData->search_parameters->device;
        $googlekeyword->position  = $domainPosition ?? 0;
        $googlekeyword->created_by = \Auth::user()->id;
        $googlekeyword->save();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keyword_details = SerpbearKeyword::where('id' , $id)->first();
       
        return view('keyword.show' , compact('keyword_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(SerpbearKeyword $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerpbearKeyword $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(SerpbearKeyword $cr)
    {
        //
    }
}
