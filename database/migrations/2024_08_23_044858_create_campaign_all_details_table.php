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
        Schema::create('campaign_all_details', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('group');
            $table->string('country_name');
            $table->string('short_code');
            $table->string('language');
            $table->string('image');
            $table->string('offer_url');
            $table->string('headlines');
            $table->string('primary_text');
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
        Schema::dropIfExists('campaign_all_details');
    }
};
