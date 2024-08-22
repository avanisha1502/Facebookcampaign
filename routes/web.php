<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SerpbearKeywordController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GoogleAdsKeywordController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\CampignController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CountryCampaignController;
use App\Http\Controllers\AdAccountController;
use App\Http\Controllers\CampaignGenerateController;
use App\Http\Controllers\CampaignReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'check.activity'], function () {
    
    Route::get('/', function () {
        phpinfo();
        return view('auth.login');
    });

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('auth/google', 'App\Http\Controllers\Auth\LoginController@redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'App\Http\Controllers\Auth\LoginController@handleGoogleCallback');

    Route::get('auth/facebook', 'App\Http\Controllers\Auth\LoginController@redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'App\Http\Controllers\Auth\LoginController@handleFacebookCallback');

    //Domain Add
    Route::get('/domain', [DomainController::class, 'index'])->name('domain.index')->middleware('auth.redirect');
    Route::get('/domain-create', [DomainController::class, 'create'])->name('domain.create')->middleware('auth.redirect');
    Route::post('/domain-store', [DomainController::class, 'store'])->name('domain.store')->middleware('auth.redirect');
    Route::get('/domain/{id}', [DomainController::class, 'show'])->name('domain.show')->middleware('auth.redirect');


    Route::get('/keyword/{id}', [SerpbearKeywordController::class, 'index'])->name('keyword.index')->middleware('auth.redirect');
    Route::get('/keyword-create/{id}', [SerpbearKeywordController::class, 'create'])->name('keyword.create')->middleware('auth.redirect');
    Route::post('/keyword-store', [SerpbearKeywordController::class, 'store'])->name('keyword.store')->middleware('auth.redirect');


    //Keyword find
    Route::get('/get-related-keywords', [SerpbearKeywordController::class, 'index'])->name('googlekeywords.index')->middleware('auth.redirect');
    Route::post('/fetch-keywords', [SerpbearKeywordController::class, 'SerpApiCall'])->middleware('auth.redirect');
    Route::get('/keyword/{id}' , [SerpbearKeywordController::class, 'show'])->name('keyword.show')->middleware('auth.redirect');


    //Country Data
    Route::post('/load-data', [CountryController::class, 'loadData'])->name('loadcountrydata')->middleware('auth.redirect');
    Route::post('/search-country', [CountryController::class , 'search'])->name('search.country')->middleware('auth.redirect');

    //Google Keyword Planner
    Route::get('/googlekeyword', [GoogleAdsKeywordController::class, 'index'])->name('googleadskeyword.index')->middleware('auth.redirect');
    Route::get('/googlekeyword-create', [GoogleAdsKeywordController::class, 'create'])->name('googleadskeyword.create')->middleware('auth.redirect');
    Route::post('/googlekeyword-store', [GoogleAdsKeywordController::class, 'store'])->name('googleadskeyword.store')->middleware('auth.redirect');
    Route::get('/googlekeyword-show/{id}', [GoogleAdsKeywordController::class, 'Show'])->name('googleadskeyword.show')->middleware('auth.redirect');
    Route::any('/googlekeyword-filter', [GoogleAdsKeywordController::class, 'Filter'])->name('googleadskeyword.filter')->middleware('auth.redirect');

    Route::get('/campaigns' , [CampaignsController::class , 'index'])->name('campaigns.index')->middleware('auth.redirect');
    //Setting 
    Route::get('/settings', [GoogleAdsKeywordController::class, 'index'])->name('settings.index')->middleware('auth.redirect');


    //create campign index ,insert, upadte,delete route
    Route::get('/campaign', [CampignController::class , 'index'])->name('index-campaign')->middleware('auth.redirect');
    Route::get('/create-campaign',  [CampignController::class , 'create'])->name('create-campaign')->middleware('auth.redirect');
    Route::post('/create-campaign',  [CampignController::class , 'store'])->name('store-campaign')->middleware('auth.redirect');
    Route::get('/show-campaign/{id}', [CampignController::class , 'show'])->name('show-campaign')->middleware('auth.redirect');
    Route::get('/edit-campaign/{id}', [CampignController::class , 'edit'])->name('edit-campaign')->middleware('auth.redirect');
    Route::put('/update-campaign/{id}',  [CampignController::class , 'update'])->name('update-campaign')->middleware('auth.redirect');
    Route::delete('/delete-campaign/{id}', [CampignController::class , 'destroy'])->name('delete-campaign')->middleware('auth.redirect');
    Route::any('/campaign-filter', [CampignController::class, 'Filter'])->name('campaign.filter')->middleware('auth.redirect');
   

    //generate-headlines
    Route::get('/generate-headlines/{id}', [CampignController::class , 'GenerateHeadLines'])->name('generate-headlines')->middleware('auth.redirect');
    Route::get('/show-generate-headlines/{id}', [CampignController::class , 'ShowGenerateHeadLines'])->name('generate-headlines-show')->middleware('auth.redirect');
    //image upload
    Route::get('/generate-headlines-images/{id}', [CampignController::class, 'ImageUpload'])->name('generate-imageUpload')->middleware('auth.redirect');
    Route::post('/generate-headlines-images/{id}', [CampignController::class, 'storeImage'])->name('generate-imageUpload-store')->middleware('auth.redirect');
    Route::get('/fetch-images', [CampignController::class, 'fetchImages'])->name('fetch-images')->middleware('auth.redirect');
    Route::delete('/delete-image', [CampignController::class, 'deleteImage'])->name('delete-image')->middleware('auth.redirect');



    //Countries Route
    Route::get('/countries', [CountryCampaignController::class, 'index'])->name('countries.index')->middleware('auth.redirect');
    Route::get('/create-countries',  [CountryCampaignController::class , 'create'])->name('create.countries')->middleware('auth.redirect');
    Route::post('/countries', [CountryCampaignController::class, 'store'])->name('store.countries')->middleware('auth.redirect');
    Route::get('/edit-country/{id}', [CountryCampaignController::class, 'edit'])->name('edit.countries')->middleware('auth.redirect');
    Route::put('/update-country/{id}', [CountryCampaignController::class, 'update'])->name('update.countries')->middleware('auth.redirect');
    Route::delete('/countries/{id}', [CountryCampaignController::class, 'destroy'])->name('destroy.countries')->middleware('auth.redirect');
    Route::any('/countries-filter', [CountryCampaignController::class, 'Filter'])->name('countries.filter')->middleware('auth.redirect');



    //setting route
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index')->middleware('auth.redirect');
    Route::get('/add-setting', [SettingController::class, 'create'])->name('add-campaign-name')->middleware('auth.redirect');
    Route::post('/setting', [SettingController::class, 'store'])->name('setting.store')->middleware('auth.redirect');

    Route::get('/AdsAccounts', [AdAccountController::class, 'CampaignList'])->name('campaign.show')->middleware('auth.redirect');
    Route::get('/AdsAccounts-create', [AdAccountController::class, 'create'])->name('campaignads.create')->middleware('auth.redirect');
    Route::post('/adaccounts-generate', [AdAccountController::class, 'getAdAccount'])->name('adaccounts')->middleware('auth.redirect');
    Route::any('/ads-filter', [AdAccountController::class, 'Filter'])->name('accounts.filter')->middleware('auth.redirect');

    Route::post('/create-adscampaign/{id}', [CampaignGenerateController::class, 'CampaignAdsCreate'])->name('campaignads.store');
    Route::get('/adsaccounts-list/{id}', [CampaignGenerateController::class, 'AccountList'])->name('adsaccounts-list')->middleware('auth.redirect');
    
    Route::get('/pixels/{accountId}', [CampaignGenerateController::class, 'getPixelsByAccount'])->name('pixels.byAccount');

    // Route::get('/get-ads-accounts', [AdAccountController::class, 'getAdAccount'])->name('getadaccounts')->middleware('auth.redirect');


    //Campaign Reporting
    Route::get('/campaign-reporting', [CampaignReportController::class, 'index'])->name('campaign-reporting')->middleware('auth.redirect');
    Route::get('/campaign-reporting-account', [CampaignReportController::class, 'account'])->name('campaign-reporting.Accounts')->middleware('auth.redirect');
    Route::get('/campaign-reporting-show/{id}', [CampaignReportController::class, 'show'])->name('campaign-reporting.show')->middleware('auth.redirect');
    Route::post('/campaign-reporting/generate', [CampaignReportController::class, 'campaignListforreport'])->name('campaignreport.generate');
    Route::post('/campaign-reporting/save/{id?}', [CampaignReportController::class, 'saveReport'])->name('campaignreport.save');
    //delete route
    Route::delete('/delete-report/{id}', [CampaignReportController::class, 'deleteReport'])->name('delete-report')->middleware('auth.redirect');

});