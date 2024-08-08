<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerpbearKeyword extends Model
{
    use HasFactory;

    protected $table = 'google_ads_keywords';

    public function DomainName(){
        return $this->hasOne('App\Models\Domain', 'id', 'domain_id');
    }
}
