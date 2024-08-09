<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Support\Facades\Http;
use App\Models\AdCampaign;

class AdAccountController extends Controller
{
    public function CampaignList(Request $request) {
        $data_filter = $request->data_filter ?? 10;
        $accounts = AdCampaign::select('name' , 'account_id' , 'act_account_id' , 'default_dsa_beneficiary' , 'pixel_id')->paginate($data_filter);
        $adscampaign = AdCampaign::all(); 
        $defaultCampaignId = $request->campaing_id ?: AdCampaign::first()->id; 
        $defaultCampaign = $adscampaign->firstWhere('id', $defaultCampaignId);
        // $defaultCampaignId = $request->campaing_id ?: AdCampaign::first()->id; 
        $adAccounts  = AdCampaign::where('id' , $defaultCampaignId)->orderBy('id','asc')->get();
       

        return view('adaccounts.index', compact('adAccounts' , 'defaultCampaignId' , 'adscampaign' , 'data_filter' , 'defaultCampaign' , 'accounts'));
    }
    public function getAdAccount()
    {
            $accessToken = env('FACEBOOK_ACCESS_TOKEN');
            if (!$accessToken) {
                return response()->json(['error' => 'Access token is missing'], 400);
            }
            
            // Initialize the Facebook SDK with necessary configurations
           $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_APP_SECRET'), 
                'default_graph_version' => 'v20.0',
            ]);
            
            $response = Http::get('https://graph.facebook.com/v20.0/me/adaccounts', [
                'fields' => 'account_id,name,id,default_dsa_beneficiary,account_status,adspixels{id,name}',
                'access_token' => $accessToken
            ]);
           
            $responseData = $response->json();
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $adAccounts = $responseData['data'];
                foreach ($adAccounts as $adsacc) {
                    // Find the record by account_id, or return null if not found
                    $existingCampaign = AdCampaign::where('account_id', $adsacc['account_id'])->first();
                    if ($existingCampaign) {
                        // Update the existing record
                        $existingCampaign->name = $adsacc['name'] ?? null;
                        $existingCampaign->ads = json_encode([]);
                        $existingCampaign->campaigns =  json_encode([]);
                        $existingCampaign->act_account_id = $adsacc['id'] ?? null;
                        $existingCampaign->account_status = $adsacc['account_status'] ?? null;
                        $existingCampaign->default_dsa_beneficiary = $adsacc['default_dsa_beneficiary'] ?? null;
                        // Check if adspixels exists and has data
                        if (isset($adsacc['adspixels']) && isset($adsacc['adspixels']['data'])) {
                            $existingCampaign->pixel_id = json_encode($adsacc['adspixels']['data']);
                        } else {
                            $existingCampaign->pixel_id = json_encode([]); // Or set to null if you prefer
                        }
                        $existingCampaign->update();
                    } else {
                        // Create a new record
                        $adsCampaign = new AdCampaign();
                        $adsCampaign->account_id = $adsacc['account_id'] ?? null;
                        $adsCampaign->name = $adsacc['name'] ?? null;
                        $adsCampaign->ads =  json_encode([]);
                        $adsCampaign->campaigns =  json_encode([]);
                        $adsCampaign->act_account_id = $adsacc['id'] ?? null;
                        $adsCampaign->account_status = $adsacc['account_status'] ?? null;
                        $adsCampaign->default_dsa_beneficiary = $adsacc['default_dsa_beneficiary'] ?? null;
                        // Check if adspixels exists and has data
                        if (isset($adsacc['adspixels']) && isset($adsacc['adspixels']['data'])) {
                            $adsCampaign->pixel_id = json_encode($adsacc['adspixels']['data']);
                        } else {
                            $adsCampaign->pixel_id = json_encode([]); // Or set to null if you prefer
                        }
                        $adsCampaign->save();
                    }
                }
                return response()->json([
                    'success' => true,
                    'accounts' => $adAccounts
                ]);
            } else {
                return response()->json(['error' => 'Unexpected response format or no data found'], 500);
            }
    }


  


    public function Filter(Request $request) {
        $search = $request->search;
        $data_filter = $request->data_filter ?? '10';
        $account = AdCampaign::query();
        if($search != null) {
            $account->where('name', 'LIKE', "%" . $search . "%")
            ->orwhere('account_id', 'LIKE', "%" . $search . "%")
            ->orwhere('act_account_id', 'LIKE', "%" . $search . "%");
                                
        } elseif ($search != null & $data_filter != null) {
            $account->where('name', 'LIKE', "%" . $search . "%")
            ->orwhere('account_id', 'LIKE', "%" . $search . "%")
            ->orwhere('act_account_id', 'LIKE', "%" . $search . "%");
        } else if($data_filter != null) {
            $account->orderBy('name')->paginate($data_filter);
        }
        $accounts = $account
        ->orderBy('name')
        ->paginate($data_filter);
        $accounts->appends(['search' => $search, 'data_filter' => $data_filter]);
      
        return view('adaccounts.index', compact('data_filter' ,'accounts'));
    
    }

    public function create() {
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $url = "https://graph.facebook.com/v20.0/me/accounts";
        $response = Http::get($url, [
            'fields' => 'name,id,cover,picture',
            'access_token' => $accessToken,
        ]);
        $pages = $response->json();
        return view('adaccounts.create' , compact('pages'));
    }

    public function CampaignAdsCreate(Request $request) {
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'), // Replace with your app id
            'app_secret' => env('FACEBOOK_APP_SECRET'), // Replace with your app secret
            'default_graph_version' => 'v20.0',
        ]);

        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $account_id = 'act_851399739819497';


        $validObjectives = [
            'CONVERSIONS',
            'PRODUCT_CATALOG_SALES',
            'OUTCOME_SALES'
        ];

        $url = "https://graph.facebook.com/v20.0/{$account_id}/campaigns";
    
        try {
            // Create Campaign
            // $response = Http::post($url, [
            //     'access_token' => $accessToken,
            //     'name' => $request->input('campaign_name') ?? 'New Sales Campaign',
            //     // 'bid_strategy' => 'AUCTION',
            //     'objective' => 'OUTCOME_SALES',
            //     'special_ad_categories' => 'NONE',
            //     'status' => 'PAUSED'    
            // ]);
            $adset_name = 'New Sales Campaign- ' . time();
            $response = Http::post($url, [
                'access_token' => $accessToken,
                'name' => $adset_name,
                'objective' => 'OUTCOME_SALES',
                'special_ad_categories' => 'NONE',
                'status' => 'PAUSED',
                'lifetime_budget' => 1000000, // Budget in cents, e.g., 1000000 = $10,000
                'bid_strategy' => 'LOWEST_COST_WITH_BID_CAP',
                'bid_strategy' => 'LOWEST_COST_WITH_BID_CAP',
                'bid_strategy_optimize_for' => 'CONVERSATIONS',
            ]);

            $campaign = $response->json();
            // dd($campaign);
            $campaign_id = $campaign['id'] ?? null;

              // Create Ad Set
              $adSetResponse = $this->createAdSet($campaign_id, $request);
              $adSet = $adSetResponse->json();
              dd($adSet);
              $adSetId = $adSet['id'] ?? null;
              dd($adSetId);
              if (!$adSetId) {
                  return response()->json(['error' => 'Ad Set ID not found'], 500);
              }
              
            // Create Ad Creative
            $creativeResponse = $this->createAdCreative($request);
            // $creative = $creativeResponse->json();
            $creative_id = $creativeResponse['id'] ?? null;
            // dd($creative_id);
            if (!$creative_id) {
                return response()->json(['error' => 'Creative ID not found'], 500);
            }

          

             // Create Ad
            // $adResponse = $this->createAd($adSetId, $request);
            $adResponse = $this->createAd($adSetId, $request->merge(['creative_id' => $creative_id]));
            $ad = $adResponse->json();
            // dd($ad);

            return response()->json([
                'campaign' => $campaign,
                'ad_set' => $adSet,
                'ad' => $ad
            ]);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  

    protected function createAdSet($campaign_id, $request)
    {
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $account_id = 'act_851399739819497';
        $page_id = $request->facebook_page;
        $url = "https://graph.facebook.com/v14.0/{$account_id}/adsets";

        return Http::post($url, [
            'access_token' => $accessToken,
            'name' => $request->input('adset_name'),
            // 'optimization_goal' => 'REACH', // Set to maximize conversions
            'billing_event' => 'IMPRESSIONS',
            // 'bid_amount' => $request->input('bid_amount'),
            'daily_budget' => $request->input('daily_budget'),
            'campaign_id' => $campaign_id,
            'start_time' => now()->toIso8601String(), 
            'status' => 'PAUSED',
            'bid_strategy' => 'LOWEST_COST_WITHOUT_CAP',
            'targeting' => [
                'geo_locations' => [
                    'location_types' => ['home', 'recent'], // To include people who live or have recently been in any location
                    'countries' => ['US'] // Empty array or leave it out to target worldwide
                ],
                'publisher_platforms' => ['facebook', 'instagram']
            ],
            'conversion_specs' => [
                'conversion_location' => 'website', // Define conversion location
                'conversion_event' => 'scroll' 
            ],
            'promoted_object' => [
                'page_id' => $page_id,// Ensure you pass the Facebook Page ID
            ]
        ]);
    }

    protected function createAd($ad_set_id, $request)
    {
        dd($request->all() , $ad_set_id);
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $account_id = 'act_851399739819497';
        $url = "https://graph.facebook.com/v20.0/{$account_id}/ads";

        return Http::post($url, [
            'access_token' => $accessToken,
            'name' => $request->input('ad_name'),
            'adset_id' => $ad_set_id,
            'creative' => [
                'creative_id' => $request->input('creative_id'),
            ],
            'status' => 'PAUSED'
        ]);
    }

 protected function uploadImage($imageFile)
    {
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $account_id = 'act_851399739819497'; // Replace with your ad account ID

        $url = "https://graph.facebook.com/v20.0/{$account_id}/adimages";
        $image_path = $imageFile->getRealPath(); // Path to the uploaded image file
        $response = Http::attach(
            'source', fopen($imageFile->getRealPath(), 'r'), 'image.jpg'
            )->post($url, [
                'access_token' => $accessToken,
            ]);
            $responseData = $response->json();
            $imageKey = 'image.jpg'; 
        return $responseData['images'][$imageKey]['hash'] ?? null;
    }


    protected function createAdCreative(Request $request)
    {
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $account_id = 'act_851399739819497'; // Replace with your ad account ID
    
        $imageFile = $request->file('image');
        $image_hash = $this->uploadImage($imageFile);
    
        $url = "https://graph.facebook.com/v20.0/{$account_id}/adcreatives";
        $primary_text = "hetdsp";
        $headline = "hetdsp";
        $description = "https://propworth.net/";
        $call_to_action = "LEARN_MORE";
        $url_tags = "https://example.com/url";
        $page_id = $request->facebook_page;
    
        $object_story_spec = [
            'page_id' => $page_id,
            'link_data' => [
                'message' => $primary_text,
                'link' => $url_tags,
                'caption' => $description,
                'image_hash' => $image_hash,
                'call_to_action' => [
                    'type' => $call_to_action,
                    'value' => [
                        'link' => $url_tags,
                    ],
                ],
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
            'access_token' => $accessToken,
            'name' => 'ADs Creative',
            'object_story_spec' => json_encode($object_story_spec, JSON_UNESCAPED_SLASHES),
            'degrees_of_freedom_spec' => json_encode($degrees_of_freedom_spec),
            'status' => 'PAUSED',
        ]);
        return $response->json();
    }


























    // protected function uploadImage($imageFile)
    // {
    //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    //     $account_id = 'act_1440720373248918'; // Replace with your ad account ID

    //     $url = "https://graph.facebook.com/v20.0/{$account_id}/adimages";
    //     $image_path = $imageFile->getRealPath(); // Path to the uploaded image file
    //     $response = Http::attach(
    //         'source', fopen($imageFile->getRealPath(), 'r'), 'image.jpg'
    //         )->post($url, [
    //             'access_token' => $accessToken,
    //         ]);
    //         $responseData = $response->json();
    //         $imageKey = 'image.jpg'; 
    //     return $responseData['images'][$imageKey]['hash'] ?? null;
    // }


    // protected function createAdCreative(Request $request)
    // {
    //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    //     $account_id = 'act_1440720373248918'; // Replace with your ad account ID
    
    //     $imageFile = $request->file('image');
    //     $image_hash = $this->uploadImage($imageFile);
    
    //     $url = "https://graph.facebook.com/v20.0/{$account_id}/adcreatives";
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
    //             'link' => $url_tags,
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
    //         'access_token' => $accessToken,
    //         'name' => 'ADs Creative',
    //         'object_story_spec' => json_encode($object_story_spec, JSON_UNESCAPED_SLASHES),
    //         'degrees_of_freedom_spec' => json_encode($degrees_of_freedom_spec),
    //         'status' => 'PAUSED',
    //     ]);
    //     return $response->json();
    // }
    
    
    // public function CampaignAdsCreate(Request $request) {
    //     $fb = new Facebook([
    //         'app_id' => env('FACEBOOK_APP_ID'), // Replace with your app id
    //         'app_secret' => env('FACEBOOK_APP_SECRET'), // Replace with your app secret
    //         'default_graph_version' => 'v20.0',
    //     ]);

    //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    //     $account_id = 'act_1440720373248918';


    //     $validObjectives = [
    //         'CONVERSIONS',
    //         'PRODUCT_CATALOG_SALES',
    //         'OUTCOME_SALES'
    //     ];

    //     $url = "https://graph.facebook.com/v17.0/{$account_id}/campaigns";
    
    //     try {
    //         $adset_name = 'New Sales Campaign- ' . time();
    //         // Create Campaign
    //         $response = Http::post($url, [
    //             'access_token' => $accessToken,
    //             'name' => $adset_name,
    //             // 'bid_strategy' => 'AUCTION',
    //             // 'objective' => 'OUTCOME_TRAFFIC',
    //           'objective' => 'OUTCOME_SALES',
    //             // 'objective' => 'MESSAGES',
    //             'special_ad_categories' => 'NONE',
    //             'status' => 'PAUSED'    
    //         ]);

    //         $campaign = $response->json();
    //         // dd($campaign);
    //         $campaign_id = $campaign['id'] ?? null;

    //         // Create Ad Creative
    //         $creativeResponse = $this->createAdCreative($request);
    //         // dd($creativeResponse);
    //         // $creative = $creativeResponse->json();
    //         $creative_id = $creativeResponse['id'] ?? null;
    //         if (!$creative_id) {
    //             return response()->json(['error' => 'Creative ID not found'], 500);
    //         }

    //         // Create Ad Set
    //         $adSetResponse = $this->createAdSet($campaign_id, $request);
    //         $adSet = $adSetResponse->json();
    //         dd($adSet);
    //         $adSetId = $adSet['id'] ?? null;
    //         dd($adSetId);
    //         if (!$adSetId) {
    //             return response()->json(['error' => 'Ad Set ID not found'], 500);
    //         }

    //          // Create Ad
    //         // $adResponse = $this->createAd($adSetId, $request);
    //         $adResponse = $this->createAd($adSetId, $request->merge(['creative_id' => $creative_id]));
    //         $ad = $adResponse->json();
    //         // dd($ad);

    //         return response()->json([
    //             'campaign' => $campaign,
    //             'ad_set' => $adSet,
    //             'ad' => $ad
    //         ]);
    //     } catch (\Facebook\Exceptions\FacebookResponseException $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     } catch (\Facebook\Exceptions\FacebookSDKException $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    // // protected function createAdSet($campaign_id, $request)
    // // {
    // //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    // //     $account_id = 'act_1440720373248918';
    // //     $page_id = $request->facebook_page;
    // //     $url = "https://graph.facebook.com/v14.0/{$account_id}/adsets";
    // //     // dd($campaign_id);
    // //     return Http::post($url, [
    // //         'access_token' => $accessToken,
    // //         'name' => $request->input('adset_name'),
    // //         'billing_event' => 'IMPRESSIONS',
    // //         'daily_budget' => $request->input('daily_budget'),
    // //         'campaign_id' => $campaign_id,
    // //         'start_time' => now()->toIso8601String(), 
    // //         'status' => 'PAUSED',
    // //         //Add bid startegy
    // //         'bid_strategy' => 'LOWEST_COST_WITHOUT_CAP',
    // //         'optimization_goal' => 'LINK_CLICKS', // Set to maximize impressions
    // //         'targeting' => [
    // //             'geo_locations' => [
    // //                 'location_types' => ['home', 'recent'], // To include people who live or have recently been in any location
    // //                 'countries' => ['US'] // Empty array or leave it out to target worldwide
    // //             ],
    // //             'publisher_platforms' => ['facebook', 'instagram']
    // //         ],
    // //         'conversion_specs' => [
    // //             'conversion_location' => 'website', // Define conversion location
    // //             'conversion_event' => 'purchase' 
    // //         ],
    // //         'promoted_object' => [
    // //             'page_id' => $page_id,// Ensure you pass the Facebook Page ID
    // //         ]
    // //     ]);
    // // }


    // protected function createAdSet($campaign_id, $request)
    // {

    //     return Http::post($url, [
    //         'access_token' => $accessToken,
    //         'name' => $request->input('adset_name'),
    //         'optimization_goal' => 'CONVERSIONS', // Ensure the optimization goal matches the objective
    //         'billing_event' => 'IMPRESSIONS',
    //         'bid_amount' => $request->input('bid_amount'),
    //         'daily_budget' => $request->input('daily_budget'),
    //         'campaign_id' => $campaign_id,
    //         'start_time' => now()->toIso8601String(), // Set start_time to current date and time
    //         'status' => 'PAUSED',
    //         'targeting' => [
    //             'geo_locations' => [
    //                 'countries' => ['US']
    //             ],
    //             'publisher_platforms' => ['facebook', 'instagram']
    //         ],
    //         'promoted_object' => [
    //             'page_id' => $request->input('page_id') // Ensure you pass the Facebook Page ID
    //         ]
    //     ]);


    //     // $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    //     // $account_id = 'act_1440720373248918';
    //     // $page_id = $request->facebook_page;
    //     // $url = "https://graph.facebook.com/v17.0/{$account_id}/adsets";
    //     // $budget = 10000; // in cents

    //     // $adSetData = [
    //     //     'access_token' => $accessToken,
    //     //     'name' => 'Basic Reach Ad Set - ' . time(),
    //     //     'campaign_id' => $campaign_id,
    //     //     'daily_budget' => $budget,
    //     //     'start_time' => now()->addHours(2)->toIso8601String(),
    //     //     'end_time' => now()->addDays(7)->toIso8601String(),
    //     //     'billing_event' => 'IMPRESSIONS',
    //     //     'optimization_goal' => 'OFFSITE_CONVERSIONS',
    //     //     'bid_strategy' => 'LOWEST_COST_WITHOUT_CAP',
    //     //     'targeting' => [
    //     //         'geo_locations' => ['countries' => ['US']],
    //     //         'age_min' => 18,
    //     //         'age_max' => 65,
    //     //     ],
    //     // ];

    //     // if ($page_id) {
    //     //     $adSetData['promoted_object'] = [
    //     //         'page_id' => $page_id,
    //     //     ];
    //     // }

    //     // return Http::post($url, $adSetData);
    // }


    // //today
    // // protected function createAdSet($campaign_id, $request)
    // // {
    // //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    // //     $account_id = 'act_1440720373248918';
    // //     $page_id = $request->facebook_page;
    // //     $url = "https://graph.facebook.com/v20.0/{$account_id}/adsets";
    // //     $budget = 10000;
    // //     $adset_name = 'New Sales ad set Campaign- ' . time();

    // //     return Http::post($url, [
    // //         'access_token' => $accessToken,
    // //         'name' => $adset_name,
    // //         'billing_event' => 'IMPRESSIONS',
    // //         'daily_budget' => $budget,
    // //         'campaign_id' => $campaign_id,
    // //         'start_time' => now()->toIso8601String(),
    // //         'status' => 'PAUSED',
    // //     //    'optimization_goal' => 'CONVERSIONS',
    // //         'optimization_goal' => 'OFFSITE_CONVERSIONS',
    // //         // 'optimization_goal' => 'OFFSITE_CONVERSIONS', 
    // //         // 'optimization_goal' => 'REACH', // Ensure this matches the campaign objective
    // //         'bid_strategy' => 'LOWEST_COST_WITHOUT_CAP', // No need for bid amount with this strategy
    // //         'targeting' => [
    // //             'geo_locations' => [
    // //                 'location_types' => ['home', 'recent'],
    // //                 'countries' => ['US']
    // //             ],
    // //             'publisher_platforms' => ['facebook', 'instagram']
    // //         ],
    // //         'conversion_specs' => [
    // //             'conversion_location' => 'website', // Define conversion location
    // //             'conversion_event' => 'PURCHASE' 
    // //         ],
    // //         'promoted_object' => [
    // //             'page_id' => $page_id,
    // //         ],
          
    // //     ]);
    // // }

    // protected function createAd($ad_set_id, $request)
    // {
    //     dd($request->all() , $ad_set_id);
    //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');
    //     $account_id = 'act_1440720373248918';
    //     $url = "https://graph.facebook.com/v20.0/{$account_id}/ads";

    //     return Http::post($url, [
    //         'access_token' => $accessToken,
    //         'name' => $request->input('ad_name'),
    //         'adset_id' => $ad_set_id,
    //         'creative' => [
    //             'creative_id' => $request->input('creative_id'),
    //         ],
    //         'status' => 'PAUSED'
    //     ]);
    // }

    // public function showCampaign($id)
    // {
    //     $accessToken = env('FACEBOOK_ACCESS_TOKEN');

    //     try {
    //         $response = $fb->get('/' . $id, $accessToken);
    //         $campaign = $response->getGraphNode();
    //         return view('campaign.show', ['campaign' => $campaign]);
    //     } catch (\Facebook\Exceptions\FacebookResponseException $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     } catch (\Facebook\Exceptions\FacebookSDKException $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    
}
