<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campign extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['vertical', 'topic', 'keyword', 'topic_campaign_name', 'topic_domain_name' , 'topic_offer_url' ,'is_regions' ,'sequence'];

    protected $casts = [
        'topic_campaign_name' => 'array',
        'topic_domain_name' => 'array',
        'topic_offer_url' => 'array'
    ];

    public function generateHeadlines()
    {
        return $this->hasOne(GenerateHeadLines::class, 'campaign_id');
    }
}
