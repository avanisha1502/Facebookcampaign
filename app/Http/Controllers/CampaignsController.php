<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function index() {
        return view('campaigns.index');
    }
}
