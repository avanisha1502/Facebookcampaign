<?php

namespace App\Http\Controllers;

use App\Models\CountryCampaign;
use Illuminate\Http\Request;

class CountryCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = CountryCampaign::paginate('10');
        $data_filter = '10';
        return view('countries.index', compact('countries' , 'data_filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'short_code' => 'required|string|max:255|unique:country_campaigns,short_code',
            'country_name' => 'required|string|max:255|unique:country_campaigns,name',
            'language' => 'required|string|max:255',
            'group' => 'required|string|max:255',
        ]);

        $countries = new CountryCampaign();
        $countries->short_code = $request->short_code;
        $countries->name = $request->country_name;
        $countries->language = $request->language;
        $countries->group = $request->group;
        $countries->save();

        return redirect()->route('countries.index')->with('success', __('Countries added successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CountryCampaign  $countryCampaign
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $countries = CountryCampaign::find($id);
        return view('countries.show', compact('countries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $countries = CountryCampaign::find($id);
        return view('countries.edit', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'short_code' => 'required|string|max:255|unique:country_campaigns,short_code,' . $id,
            'country_name' => 'required|string|max:255|unique:country_campaigns,name,' . $id,
            'language' => 'required|string|max:255',
            'group' => 'required|string|max:255',
        ]);

        $countries = CountryCampaign::find($id);
        $countries->short_code = $request->short_code;
        $countries->name = $request->country_name;
        $countries->language = $request->language;
        $countries->group = $request->group;
        $countries->update();

        return redirect()->route('countries.index')->with('success', __('Countries updated successfully!'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $countries = CountryCampaign::find($id);
        $countries->delete();
        return redirect()->route('countries.index')->with('success', __('Countries deleted successfully!'));
    }

    public function Filter(Request $request) {
        $search = $request->search;
        $data_filter = $request->data_filter ?? '10';
        $countries = CountryCampaign::query();

        if($search != null) {
            $countries->where('short_code', 'LIKE', "%" . $search . "%")
            ->orwhere('name', 'LIKE', "%" . $search . "%")
            ->orwhere('language', 'LIKE', "%" . $search . "%")
            ->orwhere('group', 'LIKE', "%" . $search . "%");
                                
        } elseif ($search != null & $data_filter != null) {
            $countries->where('short_code', 'LIKE', "%" . $search . "%")
            ->orwhere('name', 'LIKE', "%" . $search . "%")
            ->orwhere('language', 'LIKE', "%" . $search . "%")
            ->orwhere('group', 'LIKE', "%" . $search . "%");
        } else if($data_filter != null) {
            $countries->orderBy('short_code')->paginate($data_filter);
        }
        $countries = $countries
        ->orderBy('short_code')
        ->paginate($data_filter);

        $countries->appends(['search' => $search, 'data_filter' => $data_filter]);
        return view('countries.index', compact('countries', 'search', 'data_filter'));
    }
}
