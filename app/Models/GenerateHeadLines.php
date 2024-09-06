<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenerateHeadLines extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'generate_headlines';
    
    protected $fillable = [ 'country_id', 'campaign_id' ,'headline' , 'primary_text' , 'description' ];

}
