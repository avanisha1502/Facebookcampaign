<?php

namespace App\Services;

use Google\Client;
use Google\Service\Webmasters;
use Google\Service\Exception as GoogleServiceException;

class GoogleSearchConsoleService
{
    protected $client;
    protected $webmasters;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName(config('google.application_name'));
        $this->client->setAuthConfig(config('google.client_secret'));
        $this->client->addScope(Webmasters::WEBMASTERS_READONLY); // Adjust scopes as needed
    }

    public function getSearchAnalytics(string $siteUrl, string $startDate, string $endDate): array
    {
        try {
            $searchanalytics = $this->webmasters->searchanalytics->query(
                $siteUrl,
                [$startDate, $endDate]
            );

            // Process the search analytics data
            return $searchanalytics->rows; // Return only the rows for easier consumption
        } catch (GoogleServiceException $e) {
            // Handle API errors gracefully (e.g., log the error or return a specific error message)
            return [];
        }
    }

    // Add other methods for retrieving different data from Search Console API
}