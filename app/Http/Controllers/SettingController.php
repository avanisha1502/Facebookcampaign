<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\CountryCampaign;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = CountryCampaign::select('group')->distinct()->get();
        // Fetch existing settings
        $existingSettings = Setting::pluck('name')->toArray();

        // Check which groups do not have settings yet
        $groupsWithoutSettings = $groups->filter(function ($group) use ($existingSettings) {
            $settingName = $group->group;
            return !in_array($settingName, $existingSettings);
        });
        $settings = Setting::get();
        return view('settings.index', compact('settings' , 'groups' , 'groupsWithoutSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = CountryCampaign::selectRaw('MIN(id) as id, `group`')
        ->groupBy('group')
        ->get();    

        $existingSettings = Setting::pluck('name')->toArray();
        $groupsWithoutSettings = $groups->filter(function ($group) use ($existingSettings)
        {
            $settingName = $group->group;
            return !in_array($settingName, $existingSettings);
        });
        
        return view('settings.create', compact('groups' , 'existingSettings' , 'groupsWithoutSettings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the group input
        //  $request->validate([
        //     'group_name' => 'required|exists:countries,group',
        // ]);
        $countriesGroupName = CountryCampaign::find($request->group_name);
        $nameGrop = $countriesGroupName->group;
        $groupName = strtolower($nameGrop);
        $formattedGroupName = str_replace(' ', '-', $groupName);
    
        // Query to find the maximum value
        $latestSetting = Setting::orderBy('id', 'desc')->first();

        // dd($latestSetting);
        if ($latestSetting) {
        // Extract and increment the suffix
            $latestValue = $latestSetting->value;
            $parts = explode('-', $latestValue);
            $suffix = end($parts);
            // Increment the suffix
            $newSuffix = str_pad(intval($suffix) + 1, 2, '0', STR_PAD_LEFT);

            // Generate the new value with the incremented suffix
            $newValue = "{$formattedGroupName}-fb-ads-{$newSuffix}";
            } else {
            // Default to '01' if no records are found
            $newValue = "{$formattedGroupName}-fb-ads-01";
            }

        $created_at = $updated_at = date('Y-m-d H:i:s');
        $existingSetting = Setting::where('name', $nameGrop)->first();
        if ($existingSetting === null) {
            Setting::updateOrCreate(
                ['name' => $nameGrop],
                ['value' => $newValue, 'created_at' => now(), 'updated_at' => now()]
            );
             // Set flash message
            return redirect()->back()->with('success', 'New setting added successfully.');
        } else {
            // Set flash message
            return redirect()->back()->with('success', 'It already added.');
        }
        
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
