<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GenerateHeadLines;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\Utils;

class GenerateAdContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaignId;
    protected $keywords;
    protected $languages;
    protected $maxRetries = 10; // Maximum number of retries

    public function __construct($campaignId, $keywords, $languages)
    {
        $this->campaignId = $campaignId;
        $this->keywords = $keywords;
        $this->languages = $languages;
    }

    public function handle()
    {
        $client = new Client();
        $openaiKey = env('OPENAI_API_KEY');

        $promises = [];
        foreach ($this->languages as $language_data) {
            $language = $language_data->language;
            $country_id = $language_data->id;

            $promises[] = $this->generateFbAdContentAsync($client, $openaiKey, $language, $this->keywords)
                ->then(
                    function ($content) use ($country_id, $language) {
                        if ($content) {
                            $this->storeContent($content, $country_id);
                        } else {
                            // Log::warning("Generated content is incomplete or null for language $language.");
                            $this->retryJob($language, $country_id);
                        }
                    }
                )
                ->otherwise(
                    function ($reason) use ($country_id, $language) {
                        Log::error("Failed to generate content for language $language: " . $reason->getMessage());
                        // Log::error("Failed to generate content for language $language: " . $reason->getMessage());
                        $this->retryJob($language, $country_id);
                    }
                );
        }

        // Wait for all promises to complete
        $results = Utils::all($promises)->wait();

        // Re-dispatch job if any language failed
        $failedLanguages = array_filter($results, function ($result) {
            return isset($result['retry']) && $result['retry'];
        });

        if (!empty($failedLanguages)) {
            $this->retryFailedLanguages($failedLanguages);
        }
    }

    private function generateFbAdContentAsync($client, $openaiKey, $language, $text)
    {
        $prompt = "Generate a high-converting Facebook ad in $language based on the following text:
        Original Text: $text
        Please provide:
        1. A catchy headline (max 40 characters)
        2. Primary text (max 125 characters)
        3. Description (max 250 characters)
        Use a humanized, conversational tone that connects with the audience. The content should be engaging, 
        relatable, and persuasive. Focus on benefits, create a sense of urgency, and include a clear call-to-action.
        Ensure the text is high-converting by:
        - Addressing the audience's pain points or desires
        - Highlighting unique selling points
        - Using emotional triggers
        - Incorporating social proof or FOMO (Fear of Missing Out) when appropriate
        - Making the value proposition clear and compelling
        Format the output as:
        Headline: [Your generated headline]
        Primary Text: [Your generated primary text]
        Description: [Your generated description]";

        return $client->postAsync('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $openaiKey,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a highly skilled multilingual marketing expert specializing in creating engaging, high-converting Facebook ads.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 300,
                'temperature' => 0.7
            ],
            'timeout' => 60, // Adjust timeout as needed
        ])->then(
            function ($response) use ($language) {
                $body = json_decode($response->getBody(), true);
                Log::info('API Response for language ' . $language . ': ' . print_r($body, true));

                $generatedText = trim($body['choices'][0]['message']['content']);
                $lines = explode("\n", $generatedText);
                $adContent = ['language' => $language];
                
                foreach ($lines as $line) {
                    if (strpos($line, 'Headline:') === 0) {
                        $adContent['headline'] = trim(substr($line, strlen('Headline:')));
                    } elseif (strpos($line, 'Primary Text:') === 0) {
                        $adContent['primary_text'] = trim(substr($line, strlen('Primary Text:')));
                    } elseif (strpos($line, 'Description:') === 0) {
                        $adContent['description'] = trim(substr($line, strlen('Description:')));
                    }
                }

                if (!empty($adContent['headline']) && !empty($adContent['primary_text']) && !empty($adContent['description'])) {
                    return $adContent;
                } else {
                    Log::warning("Generated content for language $language is incomplete.");
                    return null;
                }
            }
        );
    }

    private function storeContent($content, $country_id)
    {
        $existingRecord = GenerateHeadLines::where('campaign_id', $this->campaignId)
            ->where('country_id', $country_id)
            ->where('language', $content['language'])
            ->first();

        if ($existingRecord) {
            $existingRecord->headline = $content['headline'];
            $existingRecord->primary_text = $content['primary_text'];
            $existingRecord->description = $content['description'];
            $existingRecord->save();
        } else {
            $generateheadlines = new GenerateHeadLines();
            $generateheadlines->campaign_id = $this->campaignId;
            $generateheadlines->country_id = $country_id;
            $generateheadlines->language = $content['language'];
            $generateheadlines->headline = $content['headline'];
            $generateheadlines->primary_text = $content['primary_text'];
            $generateheadlines->description = $content['description'];
            $generateheadlines->save();
        }
    }

    private function retryJob($language, $country_id)
    {
        // Dispatch the job again for the failed language
        dispatch(new GenerateAdContent($this->campaignId, $this->keywords, [(object)['language' => $language, 'id' => $country_id]]))
            ->onQueue($this->queue);
    }

    private function retryFailedLanguages($failedLanguages)
    {
        foreach ($failedLanguages as $failedLanguage) {
            // Extract the language and country_id from the failed result
            $language = $failedLanguage['language'];
            $country_id = $failedLanguage['country_id'];

            // Dispatch the job again for the failed language
            dispatch(new GenerateAdContent($this->campaignId, $this->keywords, [(object)['language' => $language, 'id' => $country_id]]))
                ->onQueue($this->queue);
        }
    }
}
