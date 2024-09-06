<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAdsKeyword extends Model
{
    protected $table = 'google_keyword';
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
