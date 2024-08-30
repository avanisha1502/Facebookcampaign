<?php

namespace App\Http\Controllers;

use App\Models\CampaignReport;
use Illuminate\Http\Request;
use App\Models\AdCampaign;
use Http;
use App\Models\Report;                    

class CampaignReportController extends Controller
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = env('FACEBOOK_ACCESS_TOKEN');
    }

    public function index()
    {
        $reports = \DB::table('reports')
        ->whereNull('deleted_at') // Only get non-deleted records
        ->get();
        return view('campaign_report.index' , compact('reports'));
    }

    public function account(Request $request) {
        $adscampaign = AdCampaign::all(); 
        return view('campaign_report.account' , compact('adscampaign'));
    }

    public function campaignListforreport(Request $request)
    {
        // dd($request->all() , session('accountId'));
        if (session()->has('accountId') && session('accountId') !== 'act_' . $request->account_id) {
            // Forget the old session data if a different account is selected
            session()->forget(['campaignsWithInsights', 'report_name', 'accountId', 'account', 'reports']);
        }

        // Check if the data is already stored in the session
        if (session()->has('campaignsWithInsights')) {
            $campaignsWithInsights = session('campaignsWithInsights');
            $report_name = session('report_name');
            $accountId = session('accountId');
            $account = session('account');
            $reports = session('reports');
        } else {
            $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
            $fields = 'name,account_id,insights{reach,impressions,ctr,cost_per_inline_link_click,cpm,spend,date_start,date_stop,inline_link_clicks},adsets{id,name,insights{reach,impressions,ctr,cpc,cpm,spend,date_start,date_stop,inline_link_clicks}},ads{id,adset_id,insights{reach,impressions,ctr,cpc,cpm,spend,date_start,date_stop,inline_link_clicks},name}';
            $account = $request->account_id;
            $report_name = $request->report_name ?? 'Untitled report';
            $reports = $report ?? (object) ['id' => null];
            // Ensure the date parameters are passed in the request
            $startDate = '2024-06-01';
            $endDate = '2024-08-22';
            $timeRange = [
                'time_range' => [
                    'since' => $startDate,
                    'until' => $endDate,
                ],
            ];
            
            $response = Http::withToken($this->accessToken)->get("https://graph.facebook.com/v20.0/$accountId/campaigns", [
                'fields' => $fields,
                'limit' => 100,
                'time_range' => json_encode($timeRange['time_range']),
            ]);
            $data = $response->json();
            if (isset($data['error'])) {
                return back()->withErrors(['error' => $data['error']['message']]);
            }

            $campaignsWithInsights = [];
            if (isset($data['data'])) {
                foreach ($data['data'] as $campaign) {
                    $adsetsWithInsights = [];
                    $adsWithInsights = [];
                    $campaignInsights = [];
                    if (!empty($campaign['insights']['data'])) {
                        $insights = $campaign['insights']['data'][0];
                        $campaignInsights[] = [
                            'campaign_id' => $campaign['id'],
                            'report_name' => $request->report_name ?? 'Untitled report',
                            'name' => $campaign['name'],
                            'account_id' => $campaign['account_id'],
                            'daily_budget' => $campaign['daily_budget'] ?? '',
                            'reach' => $insights['reach'] ?? null,
                            'impressions' => $insights['impressions'] ?? null,
                            'ctr' => $insights['ctr'] ?? null,
                            'cpc' => $insights['cost_per_inline_link_click'] ?? null,
                            'cpm' => $insights['cpm'] ?? null,
                            'spend' => $insights['spend'] ?? null,
                            'date_start' => $insights['date_start'] ?? null,
                            'date_stop' => $insights['date_stop'] ?? null,
                            'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                        ];
                    }
                    if (!empty($campaign['adsets']['data'])) {
                        foreach ($campaign['adsets']['data'] as $adset) {
                            if (!empty($adset['insights']['data'])) {
                                $insights = $adset['insights']['data'][0];
                                $adsetsWithInsights[] = [
                                    'adset_id' => $adset['id'],
                                    'name' => $adset['name'],
                                    'reach' => $insights['reach'] ?? null,
                                    'impressions' => $insights['impressions'] ?? null,
                                    'ctr' => $insights['ctr'] ?? null,
                                    'cpc' => $insights['cpc'] ?? null,
                                    'cpm' => $insights['cpm'] ?? null,
                                    'spend' => $insights['spend'] ?? null,
                                    'date_start' => $insights['date_start'] ?? null,
                                    'date_stop' => $insights['date_stop'] ?? null,
                                    'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                                ];
                            }
                        }
                    }
                    if (!empty($campaign['ads']['data'])) {
                        foreach ($campaign['ads']['data'] as $ad) {
                            if (!empty($ad['insights']['data'])) {
                                $insights = $ad['insights']['data'][0];
                                $adsWithInsights[] = [
                                    'ad_id' => $ad['id'],
                                    'adset_id' => $ad['adset_id'],
                                    'name' => $ad['name'],
                                    'reach' => $insights['reach'] ?? null,
                                    'impressions' => $insights['impressions'] ?? null,
                                    'ctr' => $insights['ctr'] ?? null,
                                    'cpc' => $insights['cpc'] ?? null,
                                    'cpm' => $insights['cpm'] ?? null,
                                    'spend' => $insights['spend'] ?? null,
                                    'date_start' => $insights['date_start'] ?? null,
                                    'date_stop' => $insights['date_stop'] ?? null,
                                    'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                                ];
                            }
                        }
                    }
                    $campaignsWithInsights[] = [
                        'campaign_id' => $campaign['id'],
                        'name' => $campaign['name'],
                        'campaign' => $campaignInsights,
                        'adsets' => $adsetsWithInsights,
                        'ads' => $adsWithInsights,
                    ];
                }
                // Store the data in the session
                session([
                    'campaignsWithInsights' => $campaignsWithInsights,
                    'report_name' => $report_name,
                    'accountId' => $accountId,
                    'account' => $account,
                    'reports' => $reports,
                ]);
            }
        }
        return view('campaign_report.report_preview', compact('campaignsWithInsights', 'report_name', 'accountId', 'account', 'reports'));
    }

    public function campaignListforreportolshdu(Request $request) {
        $adscampaign = AdCampaign::all(); 
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
        $fields = 'name,account_id,insights{reach,impressions,ctr,cost_per_inline_link_click,cpm,spend,date_start,date_stop,inline_link_clicks},adsets{id,name,insights{reach,impressions,ctr,cpc,cpm,spend,date_start,date_stop,inline_link_clicks}},ads{id,adset_id,insights{reach,impressions,ctr,cpc,cpm,spend,date_start,date_stop,inline_link_clicks},name}';
        // $fields = 'name,account_id,daily_budget,insights{reach,impressions,ctr,cost_per_inline_link_click,cpm,spend,date_start,date_stop,inline_link_clicks}';
        $account = $request->account_id;
        $report_name = $request->report_name ?? 'Untitled report';
        // Initialize $reports to avoid errors when the report is not yet saved
        $reports = $report ?? (object) ['id' => null];

        $response = Http::withToken($this->accessToken)->get("https://graph.facebook.com/v20.0/$accountId/campaigns", [
            'fields' => $fields,
            'limit' => 100,
        ]);
        
        $data = $response->json();
        dd($data);
        if (isset($data['error'])) {
            return back()->withErrors(['error' => $data['error']['message']]);
        }

        $campaignsWithInsights = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $campaign) {
                $adsetsWithInsights = [];
                $adsWithInsights = [];
                $campaignInsights = [];

                if (!empty($campaign['insights']['data'])) {
                    $insights = $campaign['insights']['data'][0];
                    $campaignInsights[] = [
                        'campaign_id' => $campaign['id'],
                        'report_name' => $request->report_name ?? 'Untitled report',
                        'name' => $campaign['name'],
                        'account_id' => $campaign['account_id'],
                        'daily_budget' => $campaign['daily_budget'] ?? '',
                        'reach' => $insights['reach'] ?? null,
                        'impressions' => $insights['impressions'] ?? null,
                        'ctr' => $insights['ctr'] ?? null,
                        'cpc' => $insights['cost_per_inline_link_click'] ?? null,
                        'cpm' => $insights['cpm'] ?? null,
                        'spend' => $insights['spend'] ?? null,
                        'date_start' => $insights['date_start'] ?? null,
                        'date_stop' => $insights['date_stop'] ?? null,
                        'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                    ];
                }

                if (!empty($campaign['adsets']['data'])) {
                    foreach ($campaign['adsets']['data'] as $adset) {
                        if (!empty($adset['insights']['data'])) {
                            $insights = $adset['insights']['data'][0];
                            $adsetsWithInsights[] = [
                                'adset_id' => $adset['id'],
                                'name' => $adset['name'],
                                'reach' => $insights['reach'] ?? null,
                                'impressions' => $insights['impressions'] ?? null,
                                'ctr' => $insights['ctr'] ?? null,
                                'cpc' => $insights['cpc'] ?? null,
                                'cpm' => $insights['cpm'] ?? null,
                                'spend' => $insights['spend'] ?? null,
                                'date_start' => $insights['date_start'] ?? null,
                                'date_stop' => $insights['date_stop'] ?? null,
                                'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                            ];
                        }
                    }
                }

                if (!empty($campaign['ads']['data'])) {
                    foreach ($campaign['ads']['data'] as $ad) {
                        if (!empty($ad['insights']['data'])) {
                            $insights = $ad['insights']['data'][0];
                            $adsWithInsights[] = [
                                'ad_id' => $ad['id'],
                                'adset_id' => $ad['adset_id'],
                                'name' => $ad['name'],
                                'reach' => $insights['reach'] ?? null,
                                'impressions' => $insights['impressions'] ?? null,
                                'ctr' => $insights['ctr'] ?? null,
                                'cpc' => $insights['cpc'] ?? null,
                                'cpm' => $insights['cpm'] ?? null,
                                'spend' => $insights['spend'] ?? null,
                                'date_start' => $insights['date_start'] ?? null,
                                'date_stop' => $insights['date_stop'] ?? null,
                                'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                            ];
                        }
                    }
                }

                $campaignsWithInsights[] = [
                    'campaign_id' => $campaign['id'],
                    'name' => $campaign['name'],
                    'campaign' => $campaignInsights,
                    'adsets' => $adsetsWithInsights,
                    'ads' => $adsWithInsights,
                ];
            }

            // dd($campaignsWithInsights);
        }
    
        return view('campaign_report.report_preview', compact('campaignsWithInsights' , 'report_name' , 'accountId'  ,'account' , 'reports'));
    }

    public function saveReport(Request $request , $id = null) {
        // dd($request->all());
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';

        $updatedReportName = $request->input('report_name');
        $campaignsWithInsights = $request->input('campaignsWithInsights', []);
        
       // Check if the report exists; if not, insert it
       $report = \DB::table('reports')->where('id', $id)->first();
       $randnum = rand(1111111111,9999999999);
       if ($report) {
           // Report exists, get the report_id
           $reportId = $report->id;
           \DB::table('reports')->where('id', $reportId)->update([
            'account_id' => $request->account_id,
            'report_name' => $updatedReportName ?? $report->report_name,
            'updated_at' => now(),
        ]);
       } else {
           // Report doesn't exist, insert a new record
           $reportId = \DB::table('reports')->insertGetId([
               'report_id' => $randnum,
               'report_name' => $updatedReportName,
               'account_id' => $request->account_id,
               'created_at' => now(),
               'updated_at' => now(),
           ]);
       }
       foreach ($campaignsWithInsights as $campaign) {
            $campaignData = json_decode($campaign, true);

            if ($campaignData === null) {
                continue;
            }

            $campaignDetails = isset($campaignData['campaign'][0]) ? $campaignData['campaign'][0] : [];
            $adsets = isset($campaignData['adsets']) ? $campaignData['adsets'] : [];
            $ads = isset($campaignData['ads']) ? $campaignData['ads'] : [];

            $campaignDetails['report_name'] = $updatedReportName;
            $campaignDetails['report_id'] = $reportId;
            $campaignDetails['account_id'] = $request->account_id;

            $campaignDetails['adsets'] = json_encode($adsets); // Automatically handled by Laravel as JSON
            $campaignDetails['ads'] = json_encode($ads);

            // Save or update the campaign record
            CampaignReport::updateOrCreate(
                ['campaign_id' => $campaignData['campaign_id'], 'report_id' => $reportId],
                $campaignDetails
            );
        }

        return redirect()->route('campaign-reporting')->with('success', 'Report saved successfully!');
    }

    public function campaignListforreportw(Request $request) {
        $adscampaign = AdCampaign::all(); 
        $accountId = $request->account_id ? 'act_' . $request->account_id : 'act_1440720373248918';
        $fields = 'name,account_id,daily_budget,insights{reach,impressions,ctr,cost_per_inline_link_click,cpm,spend,date_start,date_stop,inline_link_clicks}';
        $deliveryStatus = 'PAUSED';

        $response = Http::withToken($this->accessToken)->get("https://graph.facebook.com/v20.0/$accountId/campaigns", [
            'fields' => $fields, // Combine all needed insights fields in one
            'limit' => 100,
            // 'date_preset' => 'last_30d',
            
        ]);
        
        $data = $response->json();

        if (isset($data['error'])) {
            // Handle the error appropriately
            return back()->withErrors(['error' => $data['error']['message']]);
        }
    
        // Check if insights exist and filter out campaigns without insights
        $campaignsWithInsights = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $campaign) {
                if (!empty($campaign['insights']['data'])) {
                    $insights = $campaign['insights']['data'][0];
                    CampaignReport::updateOrCreate(
                        [
                            'campaign_id' => $campaign['id'],
                        ],
                        [
                            'report_name' => $request->report_name ?? 'Untitled report',
                            'name' => $campaign['name'],
                            'account_id' => $campaign['account_id'],
                            'daily_budget' => $campaign['daily_budget'] ?? '',
                            'reach' => $insights['reach'] ?? null,
                            'impressions' => $insights['impressions'] ?? null,
                            'ctr' => $insights['ctr'] ?? null,
                            'cpc' => $insights['cost_per_inline_link_click'] ?? null,
                            'cpm' => $insights['cpm'] ?? null,
                            'spend' => $insights['spend'] ?? null,
                            'date_start' => $insights['date_start'] ?? null,
                            'date_stop' => $insights['date_stop'] ?? null,
                            'inline_link_clicks' => $insights['inline_link_clicks'] ?? null,
                        ]);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignReport  $campaignReport
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reports = \DB::table('reports')->where('id', $id)->first();
        $accountId = $reports->account_id;
        $report_name = $reports->report_name;
        $campaignsWithInsights = CampaignReport::where('report_id', $id)->get();
        $account = $reports->account_id;
        return view('campaign_report.view', compact('campaignsWithInsights' , 'report_name' , 'accountId' , 'reports' , 'account'));
    }

    public function deleteReport($id) {
        $report = Report::findOrFail($id);
        $report->delete();
        CampaignReport::where('report_id', $id)->delete();

        return redirect()->route('campaign-reporting')->with('success', 'Report Deleted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaignReport  $campaignReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignReport $campaignReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampaignReport  $campaignReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaignReport $campaignReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignReport  $campaignReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignReport $campaignReport)
    {
        //
    }
}
