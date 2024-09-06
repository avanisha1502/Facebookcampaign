<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignAllDetails extends Model
{
    use HasFactory;
    use SoftDeletes; 

    protected $fillable = [ 'campaing_name' , 'group' , 'short_code' , 'country_name' , 'language' , 'headlines' , 'primary_text' ,  'image' , 'offer_url' ];
}
