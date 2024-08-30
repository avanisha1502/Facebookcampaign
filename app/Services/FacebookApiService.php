<?php

// namespace App\Services;

// use Facebook\Facebook;

// class FacebookMarketingAPI
// {
//     private $fb;

//     public function __construct()
//     {
//         $this->fb = new Facebook([
//             'app_id' => config('services.facebook.app_id'),
//             'app_secret' => config('services.facebook.app_secret'),
//             'default_graph_version' => config('services.facebook.default_graph_version'),
//         ]);
//     }

//     public function authenticate()
//     {
//         $helper = $this->fb->getRedirectLoginHelper();
//         $accessToken = $helper->getAccessToken();
//         dd($accessToken);
//         if (!isset($accessToken)) {
//             $loginUrl = $helper->getLoginUrl(route('facebook.callback'));
//             return redirect($loginUrl);
//         }

//         return $accessToken;
//     }
// }

namespace App\Services;

use Facebook\Facebook;
use Illuminate\Support\Facades\Log;

class FacebookApiService
{
    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function getAdAccounts()
    {
        // try {
            $response = $this->facebook->get('/me/adaccounts');
            Log::info('Facebook API Response', ['response' => $response->getDecodedBody()]);
            $graphNode = $response->getGraphNode();
            $adAccounts = $graphNode->getField('adaccounts')->asArray();
            
            dd($response);
            return $response->getGraphEdge()->asArray();
        // } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        //     // When Graph returns an error
        //     return ['error' => $e->getMessage()];
        // } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        //     // When validation fails or other local issues
        //     return ['error' => $e->getMessage()];
        // }
    }
}