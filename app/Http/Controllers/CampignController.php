<?php

namespace App\Http\Controllers;

use App\Models\Campign;
use Illuminate\Http\Request;
use App\Models\CountryCampaign;
use App\Models\Setting;
use GuzzleHttp\Client;
use App\Models\GenerateHeadLines;
use App\Models\CountryCampaignCampaign;
use App\Jobs\GenerateAdContent;
use App\Models\AdCampaign;
use Illuminate\Support\Facades\Http;

class CampignController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // protected $openAI;

    // public function __construct()
    // {
    //     $this->openAI =  env('OPENAI_API_KEY');
    // }

    protected $client;
    protected $openaiKey;
    protected $accessToken;
    public function __construct()
    {
        $this->client = new Client();
        $this->openaiKey = env('OPENAI_API_KEY');
        $this->accessToken = env('FACEBOOK_ACCESS_TOKEN');
    }
    

    public function index()
    {
        $campaigns = Campign::with('generateHeadlines')->paginate(10);
        $data_filter = '10';
        $adscampaign = AdCampaign::all(); 
        return view('campign.index' , compact('campaigns' , 'data_filter' , 'adscampaign'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campign.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vertical' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'keyword' => 'required|string|max:255',
            'tracking_url' => 'required|string'
        ]);

        // Check if 'is_regions' is present in the request
        $isRegions = $request->has('is_regions') ? 1 : 0;
         //get campaign in latest record
        $campaignCount = Campign::where('is_region' , '1')->count();
        $newSuffix = $campaignCount + 1;
        // Get the topic from the form input
        $topic = str_replace(' ', '-', $request->input('topic'));
        $staticUrl = "?ref_adnetwork=facebook&ref_pubsite=facebook&ref_keyword={trackingField4}&subid1={trackingField6}&subid2={trackingField5}&subid3={trackingField3}|{trackingField2}|{trackingField1}&subid4={cf_click_id}&click_id={external_id}&s2s_event_id=search&terms=";
        
        if($isRegions == 0) {
            $isRegions = $isRegions;
            $campaigns[] = $topic.'-all-fb-ads';
            $domains[] = "http://$topic-all.site";       
        } else {
            $campaigns = Campign::withTrashed()->get();
            $sequenceNumbers = $campaigns->pluck('sequence');
            $maxSequence = $sequenceNumbers->max();
            $sequence = $maxSequence + 1;

        // $lastItem = Campign::orderBy('sequence', 'desc')->first();
        // $sequence = $lastItem ? $lastItem->sequence + 1 : 1;
    
        // Define the predefined values
        $predefinedValues = CountryCampaign::select('group')->distinct()->get();
        // $predefinedValues = ['t1e', 'latin', 'asia', 'europe', 'others'];
        $campaignName = Setting::get();
       
        // Generate the domain names
        $domains = [];
        foreach ($campaignName as $value) {
        // foreach ($predefinedValues as $value) {
            $groupName = strtolower($value->name);
            $domains[] = "http://$topic-{$groupName}.site";
        }
        
        $campaigns = [];
        foreach ($campaignName as $name) {
            $names = $name->value;
            $campaigns[] = "{$sequence}-$topic-{$names}";
        }
    }        
        // Join the new URLs into a single string
        $trimmedKeyword = trim($request->keyword);

        // Split the string into an array of lines
        $keywordArray = preg_split('/\r\n|\r|\n/', $trimmedKeyword);
        
        // Filter out any empty lines
        $filteredKeywordArray = array_filter($keywordArray, fn($line) => !empty(trim($line)));
        
        // Join the array elements with a comma
        $commaSeparatedKeywords = implode(', ', $filteredKeywordArray);
         // Generate ad content for each keyword
        
         // Generate a base64-encoded key (for demonstration purposes)
        //  $key = base64_encode(random_bytes(32)); // Generate a 256-bit key and encode it in base64
        //  $decodedKey = base64_decode($key); // Decode the key to use in encryption
        //  // Encryption method and options
        //  $method = 'aes-256-cbc'; // Encryption method
        //  $ivLength = openssl_cipher_iv_length($method); // Get the required IV length
        //  // Prepare to store encoded campaign names
        //  $encodedCampaignNames = [];
        //  // $keywords = $request->keyword;
        //  $keywords = explode("\n", $request->keyword);

        //  foreach ($keywords as $campaignNamea) {
        //      // Generate a random IV
        //      $iv = openssl_random_pseudo_bytes($ivLength);
        //      // Encrypt the campaign name
        //      $encryptedData = openssl_encrypt($campaignNamea, $method, $decodedKey, 0, $iv);
        //      // Base64 encode the encrypted data and IV
        //      $base64EncryptedData = base64_encode($encryptedData);
        //      $base64Iv = base64_encode($iv);
        //      // Store the encoded data
        //      $encodedCampaignNames[] = "{$base64EncryptedData}:{$base64Iv}";
        //  }

        //  $campaignencode = implode(',', $encodedCampaignNames);
        //  $newUrls = [];
        //  foreach ($domains as $domain) {
        //      $newUrls[] = "{$domain}{$staticUrl}," . $campaignencode;
        //  }
        
        $encodedCampaignNames = [];
        
        // $keywords = $request->keyword;
        $keywords = explode("\n", $request->keyword);
        
        foreach ($keywords as $campaignName) {
            // URL encode the campaign name
            $urlEncodedData = urlencode($campaignName);
        
            // Store the encoded data
            $encodedCampaignNames[] = $urlEncodedData;
        }
        
        $campaignencode = implode(',', $encodedCampaignNames);
        $newUrls = [];
        foreach ($domains as $domain) {
            $newUrls[] = "{$domain}{$staticUrl}," . $campaignencode;
        }
        // Join the new URLs into a single string
        $trimmedTrackingUrl = trim($request->tracking_url);
        // Split the string into an array of lines
        $TrackingUrlArray = preg_split('/\r\n|\r|\n/', $trimmedTrackingUrl);
        // Filter out any empty lines
        $filteredTrackingUrlArray = array_filter($TrackingUrlArray, fn($line) => !empty(trim($line)));
        // Join the array elements with a comma
        $commaSeparatedTrackingUrls = implode(', ', $filteredTrackingUrlArray);

        // Save the campaign with the domains array
        $campaign = new Campign();
        $campaign->vertical = $request->vertical;
        $campaign->topic = $request->topic;
        $campaign->keyword = $commaSeparatedKeywords;
        $campaign->topic_campaign_name = json_encode($campaigns);
        $campaign->topic_domain_name = json_encode($domains);
        $campaign->topic_offer_url = json_encode($newUrls);
        $campaign->is_region = $isRegions;
        $campaign->sequence  = $sequence ?? NULL;
        $campaign->tracking_url = $commaSeparatedTrackingUrls;
        $campaign->save();

        return redirect()->route('index-campaign')->with('success', __('Campaign added successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $campaign = Campign::where('id' , '=' , $id)->first();
        return view('campign.show_url' , compact('campaign'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $campaign = Campign::where('id' , '=' , $id)->first();
        $adscampaign = AdCampaign::all(); 
        return view('campign.edit', compact('campaign' , 'adscampaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $campaign = Campign::where('id' , '=' , $id)->first();
         // Get the topic from the form input
        $topic = str_replace(' ', '-', $request->input('topic'));
        $isRegions = $request->is_regions ?? '0';

        $staticUrl = "?ref_adnetwork=facebook&ref_pubsite=facebook&ref_keyword={trackingField4}&subid1={trackingField6}&subid2={trackingField5}&subid3={trackingField3}|{trackingField2}|{trackingField1}&subid4={cf_click_id}&click_id={external_id}&s2s_event_id=search&terms=";
        
        // Get the current maximum sequence value
        if (is_null($campaign->sequence)) {
            $maxSequence = Campign::withTrashed()->max('sequence');
            $newSuffix = $maxSequence + 1;
        } else {
            $newSuffix = $campaign->sequence;
        }
        
        if($isRegions == 0) {
            $isRegions = $isRegions;
            $campaigns[] = $topic.'-all-fb-ads';
            $domains[] = "http://$topic-all.site";   
        } else {
            // Define the predefined values
            $predefinedValues = CountryCampaign::select('group')->distinct()->get();
            // $predefinedValues = ['t1e', 'latin', 'asia', 'europe', 'others'];
            $campaignName = Setting::get();
        
            // Generate the domain names
            $domains = [];
            foreach ($campaignName as $value) {
            // foreach ($predefinedValues as $value) {
                $groupName = strtolower($value->name);
                $domains[] = "http://$topic-{$groupName}.site";
            }
            
            $campaigns = [];
            foreach ($campaignName as $name) {
                $names = $name->value;
                $campaigns[] = "{$newSuffix}-$topic-{$names}";
            }
        }

         // Join the new URLs into a single string
         $trimmedKeyword = trim($request->keyword);

        // Split the string into an array of lines
        $keywordArray = preg_split('/\r\n|\r|\n/', $trimmedKeyword);
        
        // Filter out any empty lines
        $filteredKeywordArray = array_filter($keywordArray, fn($line) => !empty(trim($line)));
        
        // Join the array elements with a comma
        $commaSeparatedKeywords = implode(', ', $filteredKeywordArray);

       // Join the new URLs into a single string
       $trimmedTrackingUrl = trim($request->tracking_url);
       // Split the string into an array of lines
       $TrackingUrlArray = preg_split('/\r\n|\r|\n/', $trimmedTrackingUrl);
       // Filter out any empty lines
       $filteredTrackingUrlArray = array_filter($TrackingUrlArray, fn($line) => !empty(trim($line)));
       // Join the array elements with a comma
       $commaSeparatedTrackingUrls = implode(', ', $filteredTrackingUrlArray);


        $key = base64_encode(random_bytes(32)); // Generate a 256-bit key and encode it in base64
        $decodedKey = base64_decode($key); // Decode the key to use in encryption
        // Encryption method and options
        $method = 'aes-256-cbc'; // Encryption method
        $ivLength = openssl_cipher_iv_length($method); // Get the required IV length

        // Split and trim keywords
        $keywords = array_map('trim', explode(',', $request->keyword));
        // $encodedCampaignNames = []; // Array to hold encoded names
        // // dd($keywords);
        // // Encrypt and encode each keyword
        // foreach ($keywords as $campaignNamea) {
        //     // Generate a random IV
        //     $iv = openssl_random_pseudo_bytes($ivLength);
        //     // Encrypt the campaign name
        //     $encryptedData = openssl_encrypt($campaignNamea, $method, $decodedKey, 0, $iv);
        //     // Base64 encode the encrypted data and IV
        //     $base64EncryptedData = base64_encode($encryptedData);
        //     $base64Iv = base64_encode($iv);
        //     // Store the encoded data
        //     $encodedCampaignNames[] = "{$base64EncryptedData}:{$base64Iv}";
        // }
        // // Combine all encoded campaign names into a single comma-separated string
        // $campaignencode = implode(',', $encodedCampaignNames);
        // // Create new URLs with the comma-separated encoded campaign names
        // $newUrls = [];
        // foreach ($domains as $domain) {
        //     $newUrls[] = "{$domain}{$staticUrl},{$campaignencode}";
        // }
    
        // Prepare to store encoded campaign names
        $encodedCampaignNames = [];
        
        // $keywords = $request->keyword;
        $keywords = explode("\n", $request->keyword);
        
        foreach ($keywords as $campaignName) {
            // URL encode the campaign name
            $urlEncodedData = urlencode($campaignName);
        
            // Store the encoded data
            $encodedCampaignNames[] = $urlEncodedData;
        }
        
        $campaignencode = implode(',', $encodedCampaignNames);
        $newUrls = [];
        foreach ($domains as $domain) {
            $newUrls[] = "{$domain}{$staticUrl}," . $campaignencode;
        }
        
         // Save the campaign with the domains array
         $campaign->vertical = $request->vertical;
         $campaign->topic = $request->topic;
         $campaign->keyword = $commaSeparatedKeywords;
         $campaign->topic_campaign_name = json_encode($campaigns);
         $campaign->topic_domain_name = json_encode($domains);
         $campaign->topic_offer_url = json_encode($newUrls);
        // Check if sequence is null and assign the next available sequence
        if (is_null($campaign->sequence)) {
            $campaign->sequence = $newSuffix;
        }
         $campaign->is_region = $request->is_regions ?? '0';
         $campaign->tracking_url = $commaSeparatedTrackingUrls;
         $campaign->update();

         return redirect()->route('index-campaign')->with('success', __('Campaign updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $campaigns = Campign::where('id' , '=' , $id)->first();
        $campaigns->delete();

        return redirect()->route('index-campaign')->with('success', __('Campaign deleted successfully!'));
    }

    public function Filter(Request $request) {
        $search = $request->search;
        $data_filter = $request->data_filter ?? '10';
        $campaign = Campign::query();

        if($search != null) {
            $campaign->where('vertical', 'LIKE', "%" . $search . "%")
            ->orwhere('topic', 'LIKE', "%" . $search . "%")
            ->orwhere('keyword', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_campaign_name', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_domain_name', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_offer_url', 'LIKE', "%" . $search . "%");
                                
        } elseif ($search != null & $data_filter != null) {
            $campaign->where('vertical', 'LIKE', "%" . $search . "%")
            ->orwhere('topic', 'LIKE', "%" . $search . "%")
            ->orwhere('keyword', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_campaign_name', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_domain_name', 'LIKE', "%" . $search . "%")
            ->orwhere('topic_offer_url', 'LIKE', "%" . $search . "%");
        } else if($data_filter != null) {
            $campaign->orderBy('vertical')->paginate($data_filter);
        }
        $campaigns = $campaign
        ->orderBy('vertical')
        ->paginate($data_filter);
        $campaigns->appends(['search' => $search, 'data_filter' => $data_filter]);
        return view('campign.index', compact('campaigns', 'search', 'data_filter'));
        // if($search != null) {
        //     $GoogleKeyword  = 
        // } 
    }

    public function GenerateHeadLines($id) {
        $campaign = Campign::find($id);
        $keywords = $campaign->keyword;
        // $adContents = $this->generateAllLanguages($id,$keywords);
        
        $languages = \DB::table('country_campaigns')
        ->select(\DB::raw('MIN(id) as id, language'))
        ->groupBy('language')
        ->get();
    
        dispatch(new GenerateAdContent($id, $keywords, $languages));
        
        // foreach ($languages as $language_data) {
        //     $language    = $language_data->language;
        //     $country_id = $language_data->id;
        //   dispatch(new GenerateAdContent($id, $language, $keywords , $country_id));
        // }

        return redirect()->route('index-campaign')->with('success', __('Campaign ad content generated successfully!'));
    }

    // private function generateFbAdContent($language, $text)
    // {
    //     $prompt = "Generate a high-converting Facebook ad in $language based on the following text:
    
    //     Original Text: $text
    
    //     Please provide:
    //     1. A catchy headline (max 40 characters)
    //     2. Primary text (max 125 characters)
    //     3. Description (max 250 characters)
    
    //     Use a humanized, conversational tone that connects with the audience. The content should be engaging, 
    //     relatable, and persuasive. Focus on benefits, create a sense of urgency, and include a clear call-to-action.
        
    //     Ensure the text is high-converting by:
    //     - Addressing the audience's pain points or desires
    //     - Highlighting unique selling points
    //     - Using emotional triggers
    //     - Incorporating social proof or FOMO (Fear of Missing Out) when appropriate
    //     - Making the value proposition clear and compelling
        
    //     Format the output as:
    //     Headline: [Your generated headline]
    //     Primary Text: [Your generated primary text]
    //     Description: [Your generated description]
    //     ";
    
    //     $attempts = 3;
    //     while ($attempts > 0) {
    //         try {
    //             $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
    //                 'headers' => [
    //                     'Authorization' => 'Bearer ' . $this->openaiKey,
    //                     'Content-Type' => 'application/json'
    //                 ],
    //                 'json' => [
    //                     'model' => 'gpt-4o-mini',
    //                     'messages' => [
    //                         ['role' => 'system', 'content' => 'You are a highly skilled multilingual marketing expert specializing in creating engaging, high-converting Facebook ads.'],
    //                         ['role' => 'user', 'content' => $prompt]
    //                     ],
    //                     'max_tokens' => 300,
    //                     'temperature' => 0.7
    //                 ]
    //             ]);
    
    //             $body = json_decode($response->getBody(), true);
    //             $generatedText = trim($body['choices'][0]['message']['content']);
    
    //             $lines = explode("\n", $generatedText);
    //             $adContent = ['language' => $language];
    //             foreach ($lines as $line) {
    //                 if (strpos($line, 'Headline:') === 0) {
    //                     $adContent['headline'] = trim(substr($line, strlen('Headline:')));
    //                 } elseif (strpos($line, 'Primary Text:') === 0) {
    //                     $adContent['primary_text'] = trim(substr($line, strlen('Primary Text:')));
    //                 } elseif (strpos($line, 'Description:') === 0) {
    //                     $adContent['description'] = trim(substr($line, strlen('Description:')));
    //                 }
    //             }
    //             return $adContent;
    
    //         } catch (\Exception $e) {
    //             \Log::error("An error occurred for $language: " . $e->getMessage());
    //             $attempts--;
    //             if ($attempts > 0) {
    //                 sleep(1); // Delay before retrying
    //             } else {
    //                 \Log::error("Failed to generate content for language: $language after multiple attempts.");
    //                 return null;
    //             }
    //         }
    //     }
    // }

    // private function generateFbAdContent2407($language, $text)
    // {
    //     $prompt = "Generate a high-converting Facebook ad in $language based on the following text:

    //     Original Text: $text

    //     Please provide:
    //     1. A catchy headline (max 40 characters)
    //     2. Primary text (max 125 characters)
    //     3. Description (max 250 characters)

    //     Use a humanized, conversational tone that connects with the audience. The content should be engaging, 
    //     relatable, and persuasive. Focus on benefits, create a sense of urgency, and include a clear call-to-action.
        
    //     Ensure the text is high-converting by:
    //     - Addressing the audience's pain points or desires
    //     - Highlighting unique selling points
    //     - Using emotional triggers
    //     - Incorporating social proof or FOMO (Fear of Missing Out) when appropriate
    //     - Making the value proposition clear and compelling
        
    //     Format the output as:
    //     Headline: [Your generated headline]
    //     Primary Text: [Your generated primary text]
    //     Description: [Your generated description]
    //     ";
    //     // try {
    //     // dd($this->client);
    //         // $response = $this->client->chat()->create([
    //         //     'model' => 'gpt-4o',
    //         //     'messages' => [
    //         //         ['role' => 'system', 'content' => 'You are a highly skilled multilingual marketing expert specializing in creating engaging, high-converting Facebook ads.'],
    //         //         ['role' => 'user', 'content' => $prompt],
    //         //     ],
    //         //     'max_tokens' => 300,
    //         //     'temperature' => 0.7,
    //         // ]);

    //         $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $this->openaiKey,
    //                 'Content-Type' => 'application/json'
    //             ],
    //             'json' => [
    //                 'model' => 'gpt-4o-mini',
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'You are a highly skilled multilingual marketing expert specializing in creating engaging, high-converting Facebook ads.'],
    //                     ['role' => 'user', 'content' => $prompt]
    //                 ],
    //                 'max_tokens' => 300,
    //                 'temperature' => 0.7
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $generatedText = trim($body['choices'][0]['message']['content']);

    //         $lines = explode("\n", $generatedText);
    //         $adContent = ['language' => $language];
    //         foreach ($lines as $line) {
    //             if (strpos($line, 'Headline:') === 0) {
    //                 $adContent['headline'] = trim(substr($line, strlen('Headline:')));
    //             } elseif (strpos($line, 'Primary Text:') === 0) {
    //                 $adContent['primary_text'] = trim(substr($line, strlen('Primary Text:')));
    //             } elseif (strpos($line, 'Description:') === 0) {
    //                 $adContent['description'] = trim(substr($line, strlen('Description:')));
    //             }
    //         }
    //         return $adContent;

    //     // } catch (\Exception $e) {
    //     //     dd( $e->getMessage());
    //     //     Log::error("An error occurred for $language: " . $e->getMessage());
    //     //     return null;
    //     // }
    // }

    // private function generateAllLanguages($campaignId, $text)
    // {
    //     $languages = \DB::table('country_campaigns')
    //                 ->select(\DB::raw('MIN(id) as id, language'))
    //                 ->groupBy('language')
    //                 ->get();
    //     $allContent = [];
    //     foreach ($languages as $language) {
    //         $content = $this->generateFbAdContent($language->language, $text);
    //         if ($content) {

    //             $existingRecord = GenerateHeadLines::where('campaign_id', $campaignId)
    //             ->where('CountryCampaign_id', $language->id)
    //             ->where('language', $language->language)
    //             ->first();

    //             if ($existingRecord) {
    //                 // Update the existing record
    //                 $existingRecord->headline = $content['headline'] ?? $existingRecord->headline;
    //                 $existingRecord->primary_text = $content['primary_text'] ?? $existingRecord->primary_text;
    //                 $existingRecord->description = $content['description'] ?? $existingRecord->description;
    //                 $existingRecord->save();
    //             } else {
    //                 // Store the generated content in the database
    //                 $generateheadlines = new GenerateHeadLines();
    //                 $generateheadlines->campaign_id = $campaignId;
    //                 $generateheadlines->CountryCampaign_id = $language->id;
    //                 $generateheadlines->language = $language->language;
    //                 $generateheadlines->headline = $content['headline'] ?? '';
    //                 $generateheadlines->primary_text = $content['primary_text'] ?? '';
    //                 $generateheadlines->description = $content['description'] ?? '';
    //                 dd($generateheadlines);
    //                 $generateheadlines->save();
    //             }
    //             $allContent[] = $content;
    //         } else {
    //             \Log::warning("Content for language: {$language->language} could not be generated.");
    //         }
    //     }
    //     return $allContent;
    // }

    public function ShowGenerateHeadLines($id) {
       $headlines = GenerateHeadLines::where('campaign_id' , $id)->get();
       return view('campign.show_generated_headlines', compact('headlines' ));
    }

    // public function ImageUpload($id) {
    //     $campaign = Campign::find($id);
    //     $languages = GenerateHeadLines::select('language')->where('campaign_id' , $id)->get();
    //     return view('campign.upload', compact('campaign' , 'languages'));
    // }

    public function ImageUpload($id) {
        $campaign = Campign::find($id);
        $languages = GenerateHeadLines::select('language')->where('campaign_id' , $id)->get();
        $accounts = AdCampaign::select('id' ,'name' , 'account_id' , 'act_account_id' , 'account_status')->get();

        // Retrieve the images for the default selected language (if any)
        $defaultLanguage = $languages->first()->language ?? null;
        $images = [];
        if ($defaultLanguage) {
            $headline = GenerateHeadLines::where('campaign_id', $id)->where('language', $defaultLanguage)->first();
            if ($headline && $headline->images) {
                $images = $headline->images;
            }
        }
        return view('campign.upload', compact('campaign', 'languages', 'images', 'defaultLanguage'  , 'accounts'));
    }

    public function storeImage(Request $request, $id)
    {
        $newAccountId = $request->account_id;
        $language = $request->language;
        // Validate the request
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'images' => 'array|max:4',
            'language' => 'required|string',
        ]);
        
        $campaign = Campign::find($id);
        $headline = GenerateHeadLines::where('campaign_id', $id)
            ->where('language', $request->language)
            ->first();
        
        if (!$headline) {
            return redirect()->route('index-campaign')->with('error', __('Headline not found.'));
        }

        // Get the old account ID
        $oldAccountId = $headline->account_id;
        $isAccountIdChanged = $oldAccountId !== $newAccountId;
        $isLanguageChanged = $headline->language !== $language;
        // dd($imagess ,$request->hasFile('images'));
        // Decode existing images if stored as JSON string
        $existingImages = json_decode($headline->images, true) ?? [];
        $existingHashes = json_decode($headline->hashes, true) ?? [];

        $imageUrls = [];
        $imageHashes = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique filename
                $path = $image->store('campaign-images', 'r2');
                // Create the URL for the uploaded image
                $campaignImages = "https://pub-fe8deb8da8714e919596347e9bf9bb3f.r2.dev/" . $path;
                // Store the URL in the array
                $imageUrls[] = $campaignImages;
    
                // Upload the image to Facebook and get the hash
                $imageHash = $this->uploadImage($campaignImages, $newAccountId);
                if ($imageHash) {
                    $imageHashes[] = $imageHash;
                }
            }
        } else {
            $allImages = $existingImages;
            $allHashes = $existingHashes;
        }

        // Determine if any field needs updating
        $updateFields = $isAccountIdChanged || $isLanguageChanged || $request->hasFile('images');
        // dd($isAccountIdChanged);
        // Update all campaigns with the old account ID if the account ID has changed
            $campaigns = GenerateHeadLines::where('campaign_id', $id)->get();
            if($campaigns) {
                foreach($campaigns as $campaign) {
                    GenerateHeadLines::where('campaign_id', $id)->update(['account_id' => $newAccountId]);
                }
            }
    // dd($allImages);
        if ($updateFields) {
            // Update all fields
            $headline->account_id = $newAccountId;
            $headline->language = $language;
            $headline->images = json_encode($imageUrls);
            $headline->hashes = json_encode($imageHashes);
        }

        // Save changes
        $headline->update();

         // Handle existing images conversion to hashes
        // foreach ($existingImages as $existingImageUrl) {
        //     if (!in_array($existingImageUrl, $imageUrls)) {
        //         $imageHash = $this->uploadImage($existingImageUrl, $accountId);
        //         // dd($imageHash , $existingImageUrl);
        //         if ($imageHash) {
        //             $imageHashes[] = $imageHash;
        //             // $imageUrls[] = $existingImageUrl; // Ensure existing image URLs are kept
        //         }
        //     }
        // }

        // $allImages = array_merge($existingImages, $imageUrls);
        // $allHashes = array_merge($existingHashes, $imageHashes);

        // Process new images
        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         // Generate a unique filename
        //         $path = $image->store('campaign-images', 'r2');
        //         // Create the URL for the uploaded image
        //         $campaignImages = "https://pub-fe8deb8da8714e919596347e9bf9bb3f.r2.dev/" . $path;
        //         // Store the URL in the array
        //         $imageUrls[] = $campaignImages;
        //     }
        // }

        // Merge existing images with new images
        // $allImages = array_merge($existingImages, $imageUrls);
        // $headline->images = json_encode([
        //     'urls' => $allImages,
        //     'hashes' => $imageHashes,
        // ]); // Encode array to JSON string
        // $headline->update();

        // dd($allImages);
        

        // Update or save images
        // $headline->account_id = $accountId ?? Null;
        // $headline->images = json_encode($allImages); // Encode array to JSON string
        // $headline->hashes = json_encode($imageHashes);
        // $headline->update();

        return redirect()->route('index-campaign')->with('success', __('Language wise Images uploaded successfully!'));
    }

    protected function uploadImage($imageUrl , $accountId)
    {
        $account_id = 'act_' . $accountId;
        $accountId = AdCampaign::where('account_id' , $accountId)->first();
        $accounts = $accountId->act_account_id;
        // Download the image
        $tempImage = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($tempImage, file_get_contents($imageUrl));
    
        $url = "https://graph.facebook.com/v20.0/{$accounts}/adimages";
        
        // Upload the image
        $response = Http::attach(
            'source', fopen($tempImage, 'r'), basename($imageUrl)
        )->post($url, [
            'access_token' => $this->accessToken,
        ]);
        
        // Delete the temporary file
        unlink($tempImage);
        
        $responseData = $response->json();
    
        // Check the response
        if ($response->failed()) {
            \Log::error("Failed to upload image", ['response' => $responseData]);
            return null;
        }
    
        // Extract and return the image hash
        $imageKey = basename($imageUrl);
        return $responseData['images'][$imageKey]['hash'] ?? null;
    }


    public function deleteImage(Request $request)
    {
        $campaignId = $request->input('campaign_id');
        $imageUrl = $request->input('image_url');

        $headline = GenerateHeadLines::where('campaign_id', $campaignId)
            ->where('language', $request->language)
            ->first();

        if ($headline) {
            $existingImages = json_decode($headline->images, true) ?? [];
            // Remove the image URL from the array
            $updatedImages = array_filter($existingImages, function ($url) use ($imageUrl) {
                return $url !== $imageUrl;
            });

            $headline->images = json_encode(array_values($updatedImages));
            $headline->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    

    public function fetchImages(Request $request ) {
        $language = $request->input('language');
        $campaign = $request->input('campaign_id');
        // dd($language , $campaign);
        $headline = GenerateHeadLines::where('campaign_id', $campaign)
            ->where('language', $language)
            ->first();
    
        $images = $headline ? $headline->images : [];
    
        return response()->json(['images' => $images]);
    }
}
