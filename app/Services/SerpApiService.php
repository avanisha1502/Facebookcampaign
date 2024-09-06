<?php

namespace App\Services;

use GuzzleHttp\Client;

class SerpApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://serpapi.com/',
            'timeout' => 10,
        ]);
    }

    public function search($apiKey, $query)
    {
        $response = $this->client->request('GET', 'search', [
            'query' => array_merge($query, ['api_key' => $apiKey]),
        ]);

        return json_decode($response->getBody()->getContents());
    }
}