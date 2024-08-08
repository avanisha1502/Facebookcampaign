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
        Schema::create('google_keyword', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('country_id')->nullable();
            $table->string('monthly_search')->nullable();
            $table->longText('search_trend')->nullable();
            $table->string('competition')->nullable();
            $table->string('low_bid_range')->nullable();
            $table->string('high_bid_range')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_keyword');
    }
};
