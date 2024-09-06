<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOffer extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'sub_offers';

    protected $fillable = [
        'offer_id',
        'offer_sub_topic_name',
        'offer_sub_strategy',
        'offer_sub_pixel',
        'offer_sub_feed_provide',
        'offer_sub_custom_field',
        'offer_sub_group',
        'offer_sub_country_name',
        'offer_sub_short_code',
        'offer_sub_language',
        'offer_sub_campaign_name',
        'offer_sub_image',
        'offer_sub_offer_url',
        'offer_sub_headlines',
        'offer_sub_primary_text',
        'offer_sub_description',
        'sequence'
    ];
}
