<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdCampaign extends Model
{
    use HasFactory;

    protected $table = 'ad_accounts';

    protected $fillable = ['account_id' , 'name' , 'ads' , 'campaigns' , 'act_account_id' , 'account_status'];

}
