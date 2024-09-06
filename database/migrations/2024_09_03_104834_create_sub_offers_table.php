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
        Schema::create('sub_offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_id')->nullable();
            $table->string('offer_sub_topic_name')->nullable();
            $table->string('offer_sub_strategy')->nullable();
            $table->string('offer_sub_pixel')->nullable();
            $table->string('offer_sub_feed_provide')->nullable();
            $table->string('offer_sub_custom_field')->nullable();
            $table->string('offer_sub_group')->nullable();
            $table->string('offer_sub_country_name')->nullable();
            $table->string('offer_sub_short_code')->nullable();
            $table->string('offer_sub_language')->nullable();
            $table->string('offer_sub_campaign_name')->nullable();
            $table->text('offer_sub_image')->nullable();
            $table->text('offer_sub_offer_url')->nullable();
            $table->text('offer_sub_headlines')->nullable();
            $table->text('offer_sub_primary_text')->nullable();
            $table->text('offer_sub_description')->nullable();
            $table->text('sequence')->nullable();
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
        Schema::dropIfExists('sub_offers');
    }
};
