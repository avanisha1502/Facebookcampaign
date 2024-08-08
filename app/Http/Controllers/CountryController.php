<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loadData(Request $request)
    {
        $response = Http::get('https://restcountries.com/v3.1/all');

        if ($response->successful()) {
            $countries = $response->json();
    
            foreach ($countries as $country) {
                $name = $country['name']['common'];
                $code = $country['cca2']; // Accessing the country code
                $image_url = $country['flags']['png'];
                  // Check if currencies key exists
        
                if (isset($country['currencies'])) {
                    // Get the first currency code
                    $currencyCode = array_key_first($country['currencies']);
                    // Access the currency data using the currency code
                    $currencyData = $country['currencies'][$currencyCode];
                    // Retrieve the currency symbol, default to currency code if symbol is not available
                    $currencySymbol = $currencyData['symbol'] ?? $currencyCode;
                } else {
                    // Set default currency symbol if currencies key is missing
                    $currencySymbol = null;
                }
                // Create or update the country in the database
                Country::updateOrCreate(
                    ['name' => $name],
                    ['country_code' => $code, 'currency_symbol' => $currencySymbol ,'image_url' => $image_url]
                );
            }

            return response()->json(['message' => 'Data loaded successfully.']);
        } else {
            // Handle the case where the request failed
            return response()->json(['error' => 'Failed to fetch countries.'], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        // Perform the search query
        $countries = Country::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($countries);
    }
}
