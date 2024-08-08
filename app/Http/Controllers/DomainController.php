<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\SerpbearKeyword;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::where('created_by' , \Auth::user()->id)->get();
      
        return view('domain.index' , compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('domain.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'domain_name' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $domain = new Domain();
        $domain->domain_name = $request->domain_name;
        $domain->created_by = \Auth::user()->id;
        $domain->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show($domain_id)
    {
        $keyword_data = SerpbearKeyword::where('created_by' , \Auth::user()->id)->where('domain_id' , $domain_id)->get();
        $domain_name = Domain::where('id' , $domain_id)->first();
        return view('keyword.index' , compact('keyword_data','domain_id' , 'domain_name'));
    }

    private function extractFaviconUrl($domain)
    {
        $curl = curl_init($domain);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl);
        curl_close($curl);
    
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        dd($html);
        $links = $dom->getElementsByTagName('link');
        dd($links);
        foreach ($links as $link) {
            if ($link->getAttribute('rel') == 'icon') {
                return $link->getAttribute('href');
            }
        }
        // Fallback to default favicon location
        return 'https://example.com/favicon.ico';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        //
    }
}
