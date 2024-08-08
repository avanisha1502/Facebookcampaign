<?php

namespace App\Http\Controllers;

use App\Models\GoogleAdsKeyword;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Ads\GoogleAds\Lib\V16\GoogleAdsClient;
use Google\Ads\GoogleAds\Lib\V16\GoogleAdsClientBuilder as GoogleAdsClientBuilder;
use GPBMetadata\Google\Ads\GoogleAds\V16\Services\KeywordPlanService;
use Google\ApiCore\ApiException;
use Google\Ads\GoogleAds\Examples\Utils\ArgumentNames;
use Google\Ads\GoogleAds\Examples\Utils\ArgumentParser;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V16\GoogleAdsException;
use Google\Ads\GoogleAds\Util\V16\ResourceNames;
use Google\Ads\GoogleAds\V16\Enums\KeywordPlanNetworkEnum\KeywordPlanNetwork;
use Google\Ads\GoogleAds\V16\Enums\KeywordPlanForecastIntervalEnum\KeywordPlanForecastInterval;
use Google\Ads\GoogleAds\V16\Errors\GoogleAdsError;
use Google\Ads\GoogleAds\V16\Services\GenerateKeywordIdeaResult;
use Google\Ads\GoogleAds\V16\Services\KeywordSeed;
use Google\Ads\GoogleAds\V16\Services\UrlSeed;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenInterface;
use Google\Ads\GoogleAds\V16\Services\GenerateKeywordIdeasRequest;
use Google\Ads\GoogleAds\V16\Enums\KeywordPlanNetworkEnum; // Update the namespace
use Google\Ads\GoogleAds\V16\Services\KeywordPlanIdeaServiceClient;
use App\Models\Country;
use GPBMetadata\Google\Ads\GoogleAds\V16\Services\GeoTargetConstantService;
use Google\Ads\GoogleAds\V16\Services\SuggestGeoTargetConstantsRequest;
use Google\Ads\GoogleAds\V16\Services\GeoTargetConstantSuggestionParameter;
use Google\Ads\GoogleAds\V16\Services\GeoTargetConstantServiceClient;
use GPBMetadata\Google\Ads\GoogleAds\V16\Resources\GeoTargetConstant;
use Google\Ads\GoogleAds\V16\Services\SuggestGeoTargetConstantsRequest\LocationNames;
use GPBMetadata\Google\Ads\GoogleAds\V16\Enums\KeywordPlanAggregateMetricEnum;
use Google\Ads\GoogleAds\V16\Enums\KeywordPlanAggregateMetricsEnum;
use Google\Ads\GoogleAds\V16\Common\KeywordPlanAggregateMetrics;
use Google\Ads\GoogleAds\V16\Services\GenerateKeywordHistoricalMetricsRequest;
use Google\Ads\GoogleAds\V16\Services\GenerateKeywordHistoricalMetricsResult;
use App\Services\SerpApiService;
use GuzzleHttp\Client;

class GoogleAdsKeywordController extends Controller
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
    public function index()
    {
        $keywordSuggestions = GoogleAdsKeyword::with('country')
        ->where('created_by', \Auth::user()->id)
        ->where('input_keyword' , '0')
        ->paginate(10);

        $KeyProvides = GoogleAdsKeyword::with('country')
            ->where('input_keyword' , '1')
            ->where('created_by', \Auth::user()->id)
            ->get();

        $data_filter = '10';
        return view('googleadskeyword.index' , compact('keywordSuggestions' , 'data_filter' , 'KeyProvides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('googleadskeyword.create' , compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    
    public function store(Request $request) {
        $keywords = $request->input('keyword'); // Get the input string of keywords
         // Initialize countryName variable based on the selected country
         if($request->input('country') != null) {
            $countryName = Country::find($request->country);
        } else {
            $countryName = 'US';
        }

        // Split the input string into an array of keywords
        $keywordArray = explode(',', $keywords);

        foreach ($keywordArray as $keyword) {
            // Trim each keyword to remove any extra spaces
            $keyword = trim($keyword);

            // Perform validation for each keyword
            $validator = \Validator::make(
                ['keyword' => $keyword],
                [
                    'keyword' => 'required|string|unique:google_keyword,name,NULL,id,country_id,' . ($request->country ?? 'NULL'),
                ]
            );

            // Check if validation fails for the current keyword
            if ($validator->fails()) {
                continue; // Skip to the next keyword if validation fails
            }

           
            // Initialize Google Ads API client credentials
            $clientId = env('GOOGLE_CLIENT_ID');
            $clientSecret = env('GOOGLE_CLIENT_SECRET');
            $refreshToken = env('GOOGLE_REFRESH_TOKEN');
            $customerId = env('GOOGLE_CUSTOMER_ID');
            $devloperToken = env('GOOGLE_DEVELOPER_TOKEN');

            $scope = ['https://www.googleapis.com/auth/adwords'];

            // Create OAuth2 credentials
            $oAuth2Credential = new UserRefreshCredentials(
                $scope,
                [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'refresh_token' => $refreshToken
                ]
            );

            // Build Google Ads API client
            $googleAdsClient = (new GoogleAdsClientBuilder())
                ->withOAuth2Credential($oAuth2Credential)
                ->withDeveloperToken($devloperToken)
                ->build();

            // Create a keyword seed with the current keyword
            $keywordSeed = new KeywordSeed();
            $keywordSeed->setKeywords([$keyword]);

            // Get the geographic location criteria for the desired country
            $countryCode = $countryName->country_code;
            // $Country = Country::find($request->country);
            $geoTargetConstantIds = $this->getGeoTargetConstantId($googleAdsClient, $countryCode);

            // Generate keyword ideas request
            $request = new GenerateKeywordIdeasRequest();
            $request->setCustomerId($customerId);
            $request->setKeywordPlanNetwork(KeywordPlanNetwork::GOOGLE_SEARCH_AND_PARTNERS);
            $request->setKeywordSeed($keywordSeed);
            $request->setGeoTargetConstants($geoTargetConstantIds);

            $response = $googleAdsClient->getKeywordPlanIdeaServiceClient()->generateKeywordIdeas($request);

            // Process the response to extract keyword suggestions
            foreach ($response->iterateAllElements() as $result) {
                $CountryId = $countryName->id;
                // Extract keyword details and metrics
                $keywordText = $result->getText();
                $metrics = $result->getKeywordIdeaMetrics();

                // Check if bid-related metrics are available
                $lowBid = $highBid = '';
                if (!is_null($metrics) && $metrics->hasLowTopOfPageBidMicros() && $metrics->hasHighTopOfPageBidMicros()) {
                    $lowBid = $metrics->getLowTopOfPageBidMicros() / 1000000; // Convert from micros to currency
                    $highBid = $metrics->getHighTopOfPageBidMicros() / 1000000; // Convert from micros to currency
                }

                $jsonData = [];
                if (!is_null($metrics)) {
                    foreach ($metrics->getMonthlySearchVolumes() as $monthlySearchVolume) {
                        $jsonData[] = [
                            'year' => $monthlySearchVolume->getYear(),
                            'month' => $monthlySearchVolume->getMonth(),
                            'monthly_searches' => $monthlySearchVolume->getMonthlySearches()
                        ];
                    }
                }
                $jsonString = json_encode($jsonData);
                $averageMonthlySearches = '0';
                $competitionLevel = '0';

                if (!is_null($result->getKeywordIdeaMetrics())) {
                    $averageMonthlySearches = $result->getKeywordIdeaMetrics()->getAvgMonthlySearches() ?? '0';
                    $competitionLevel = $result->getKeywordIdeaMetrics()->getCompetition() ?? '0';
                }

                // Save keyword data to the database
                $googleKeywordplanner = new GoogleAdsKeyword();
                $googleKeywordplanner->name = $keywordText;
                $googleKeywordplanner->country_id = $CountryId;
                $googleKeywordplanner->monthly_search = $averageMonthlySearches;
                $googleKeywordplanner->search_trend = $jsonString;
                $googleKeywordplanner->competition = $competitionLevel;
                $googleKeywordplanner->low_bid_range = $lowBid;
                $googleKeywordplanner->high_bid_range = $highBid;
                $googleKeywordplanner->input_keyword = (strtolower($keywordText) == strtolower($keyword)) ? '1' : '0';
                $googleKeywordplanner->created_by = \Auth::user()->id;
                $googleKeywordplanner->save();
            }
        }

        return redirect()->back()->with('success', __('Keywords added successfully!'));
    }

    private function getGeoTargetConstantId($googleAdsClient, $countryCode)
    {
         // Initialize a Google Ads API service client
        $geoTargetConstantServiceClient = $googleAdsClient->getGeoTargetConstantServiceClient();
        $locale = 'en';
        $Country = Country::where('country_code' , $countryCode)->first();
        $CountryName = $Country->name;
        // $locationNames = ['Paris', 'Quebec', 'Spain', 'Deutschland'];
        // Prepare a request to search for the GeoTargetConstant
        $response = $geoTargetConstantServiceClient->suggestGeoTargetConstants(
            new SuggestGeoTargetConstantsRequest([
                'locale' => $locale,
                'country_code' => $countryCode,
                'location_names' => new LocationNames(['names' => [$CountryName]])
                ])
        );
        // Extract the GeoTargetConstant ID from the response
        $geoTargetConstantIds = [];
        foreach ($response->getGeoTargetConstantSuggestions() as $suggestion) {
            $geoTargetConstantIds[] = $suggestion->getGeoTargetConstant()->getResourceName();
        }
    
        return $geoTargetConstantIds;
    } 


    public function show($id)
    {
        $GoogleKeyword = GoogleAdsKeyword::find($id);
        $Country = Country::find($GoogleKeyword->country_id);
        $organicResults = [];
        $numPerPage = 100;
        $page = 1;
        //SerpApi key
        
        //Serprobot api
        $apiKey = env('GOOGLE_API_KEY');
         // Loop to fetch all pages of results
        //  do {
            // Construct the query parameters for the API request
            $client = new Client();
            $bodyData = [
                "url"=> "https://www.google.com",
                'module' => 'GoogleScraper',
                'params' => [
                    'query' => $GoogleKeyword->name,
                    'country' => $Country->country_code,
                    'num' => $numPerPage,
                    'page' => $page,
                ],
            ];
            while (count($organicResults) < 100) {
                // Make a request to the API for each page of results
                $response = $client->request('POST', 'https://api.scrapingrobot.com/?token=' . $apiKey, [
                    'body' => json_encode($bodyData + ['page' => $page]),
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                ]);
            
                $data = json_decode($response->getBody(), true);
            
                // Check if there are organic results
                if (isset($data['result']['organicResults']) && is_array($data['result']['organicResults'])) {
                    // Merge the organic results into the $results array
                    $organicResults = array_merge($organicResults, $data['result']['organicResults']);
                }
            
                // If there are no more pages, break out of the loop
                if (!$data['result']['hasNextPage']) {
                    break;
                }
            
                // Increment the page number for the next request
                $page++;
            }
        return view('googleadskeyword.view' , compact('GoogleKeyword' , 'organicResults' , 'Country'));
    }

    public function Filter(Request $request) {
        $search = $request->search;
        $data_filter = $request->data_filter ?? '10';
        $googleKeyword = GoogleAdsKeyword::query();

        if($search != null) {
            $googleKeyword->where('name', 'LIKE', "%" . $search . "%");
        } elseif ($search != null & $data_filter != null) {
            $googleKeyword->where('name', 'LIKE', "%" . $search . "%");
        } else if($data_filter != null) {
            $googleKeyword->orderBy('name')->paginate($data_filter);
        }
        $keywordSuggestions = $googleKeyword
        ->with('country')
        ->where('input_keyword' , '0')
        ->where('created_by', \Auth::user()->id)
        ->orderBy('name')
        ->paginate($data_filter);
        $keywordSuggestions->appends(['search' => $search, 'data_filter' => $data_filter]);

        $KeyProvides = GoogleAdsKeyword::with('country')
            ->where('input_keyword' , '1')
            ->where('created_by', \Auth::user()->id)
            ->get();


        return view('googleadskeyword.index', compact('keywordSuggestions', 'search', 'data_filter' , 'KeyProvides'));
        // if($search != null) {
        //     $GoogleKeyword  = 
        // } 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoogleAdsKeyword  $googleAdsKeyword
     * @return \Illuminate\Http\Response
     */
    public function edit(GoogleAdsKeyword $googleAdsKeyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoogleAdsKeyword  $googleAdsKeyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoogleAdsKeyword $googleAdsKeyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoogleAdsKeyword  $googleAdsKeyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoogleAdsKeyword $googleAdsKeyword)
    {
        //
    }
}
