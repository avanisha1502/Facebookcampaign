<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_offer_ads_creatives', function (Blueprint $table) {
            $table->id();
            $table->string('main_offer_id')->nullable();
            $table->string('sub_offer_id')->nullable();
            $table->string('sub_offer_ad_craetive_campaign_name')->nullable();
            $table->text('sub_offer_ad_craetive_sub_image')->nullable();
            $table->text('sub_offer_ad_craetive_offer_url')->nullable();
            $table->text('sub_offer_ad_craetive_headlines')->nullable();
            $table->text('sub_offer_ad_craetive_primary_text')->nullable();
            $table->text('sub_offer_ad_craetive_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_offer_ads_creatives');
    }
};
