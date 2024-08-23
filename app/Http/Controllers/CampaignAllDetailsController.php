<?php

namespace App\Http\Controllers;

use App\Models\CampaignAllDetails;
use Illuminate\Http\Request;
use App\Models\CountryCampaign;
use Illuminate\Support\Facades\Storage;

class CampaignAllDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $manualCmapiagns = CampaignAllDetails::all();
        return view('manual_campaigns.index' , compact('manualCmapiagns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = CountryCampaign::select('group' , 'name', 'short_code', 'language')->get();
        $uniqueGroups = $groups->unique('group');
        return view('manual_campaigns.create' , compact('groups' , 'uniqueGroups'));
    }
    
    public function getCountriesByGroup(Request $request)
    {
        $group = $request->input('group');
        
        // Fetch countries and related information based on the selected group
        $countries = CountryCampaign::where('group', $group)->get(['name', 'short_code', 'language']);
        // dd($countries);
        return response()->json($countries);
    }

    public function getCountryDetails(Request $request)
    {
        $country = $request->input('country');
        
        // Fetch short code and language based on the selected country
        $countryDetails = CountryCampaign::where('name', $country)->first(['short_code', 'language']);
       // Fetch all possible short codes and languages
        $allShortCodesLanguages = CountryCampaign::select('short_code', 'language')->get();

        return response()->json([
            'short_code' => $countryDetails->short_code,
            'language' => $countryDetails->language,
            'all_short_codes' => $allShortCodesLanguages->pluck('short_code'),
            'all_languages' => $allShortCodesLanguages->pluck('language')->unique()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'campaign_name' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'short_code' => 'required|string|max:10',  // assuming short codes are not too long
            'language' => 'required|string|max:100', // assuming languages are not too long
            'offer_url' => 'required', // validate that this is a valid URL
            'headline' => 'required|string|max:500', // assuming headlines are not too long
            'primary_text' => 'required|string|max:1000', // assuming primary text is not too long
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // validate image type and size
        ]);

        $image =$request->file('image');
        $path = $image->store('campaign-manual-images', 'r2');
        $campaignImages = "https://pub-fe8deb8da8714e919596347e9bf9bb3f.r2.dev/" . $path;

        // Save the campaign data
        $campaign = new CampaignAllDetails();
        $campaign->campaign_name = $request->input('campaign_name');
        $campaign->group = $request->input('group');
        $campaign->country_name = $request->input('country');
        $campaign->short_code = $request->input('short_code');
        $campaign->language = $request->input('language');
        $campaign->offer_url = $request->input('offer_url');
        $campaign->headlines = $request->input('headline');
        $campaign->primary_text = $request->input('primary_text');
        $campaign->image = $campaignImages; // Store the image path
        $campaign->save();

        return redirect()->route('new-campaign-manually.index')->with('success', 'Campaign saved successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignAllDetails  $campaignAllDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaignAllDetails = CampaignAllDetails::where('id' , $id)->first();
        return view('manual_campaigns.show', compact('campaignAllDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaignAllDetails  $campaignAllDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groups = CountryCampaign::select('group' , 'name', 'short_code', 'language')->get();
        $uniqueGroups = $groups->unique('group');
        $campaignAllDetails = CampaignAllDetails::where('id' , $id)->first();
        $allCountries = CountryCampaign::all();
        return view('manual_campaigns.edit' ,compact('campaignAllDetails' , 'uniqueGroups' , 'allCountries'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampaignAllDetails  $campaignAllDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campaignAllDetails = CampaignAllDetails::where('id' , $id)->first();

        $validatedData = $request->validate([
            'campaign_name' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'short_code' => 'required|string|max:10',  // assuming short codes are not too long
            'language' => 'required|string|max:100', // assuming languages are not too long
            'offer_url' => 'required', // validate that this is a valid URL
            'headline' => 'required|string|max:500', // assuming headlines are not too long
            'primary_text' => 'required|string|max:1000', // assuming primary text is not too long
        ]);

        if ($request->file('image') ) {
            $image = $request->file('image');
            $oldPath = str_replace("https://pub-fe8deb8da8714e919596347e9bf9bb3f.r2.dev/", "", $campaignAllDetails->image);
            Storage::disk('r2')->delete($oldPath);

            $path = $image->store('campaign-manual-images', 'r2');
            $campaignImages = "https://pub-fe8deb8da8714e919596347e9bf9bb3f.r2.dev/" . $path;
        } else {
            $campaignImages = $campaignAllDetails->image;
        }

        $campaignAllDetails->campaign_name = $request->input('campaign_name');
        $campaignAllDetails->group = $request->input('group');
        $campaignAllDetails->country_name = $request->input('country');
        $campaignAllDetails->short_code = $request->input('short_code');
        $campaignAllDetails->language = $request->input('language');
        $campaignAllDetails->offer_url = $request->input('offer_url');
        $campaignAllDetails->headlines = $request->input('headline');
        $campaignAllDetails->primary_text = $request->input('primary_text');
        $campaignAllDetails->image = $campaignImages; // Store the image path
        $campaignAllDetails->save();

        return redirect()->route('new-campaign-manually.index')->with('success', 'Campaign saved successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignAllDetails  $campaignAllDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaignAllDetails = CampaignAllDetails::where('id' , $id)->first();
        $campaignAllDetails->delete();
        return redirect()->route('new-campaign-manually.index')->with('success', 'Campaign deleted successfully');
    }
}
