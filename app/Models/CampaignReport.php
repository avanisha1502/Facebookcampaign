<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'report_name', 'report_id' ,'campaign_id', 'name', 'account_id', 'adsets', 'ads','daily_budget', 
        'reach', 'impressions', 'ctr', 'cpc', 'cpm', 'spend',
        'date_start', 'date_stop' , 'inline_link_clicks'
    ];

    public function account()
    {
        return $this->belongsTo(AdCampaign::class, 'account_id', 'account_id');
    }
}
