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
        Schema::create('google_ads_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->nullable();
            $table->string('domain_id')->nullable();
            $table->string('url')->nullable();
            $table->string('position')->nullable();
            $table->string('country')->nullable();
            $table->string('best')->nullable();
            $table->string('total_search')->nullable();
            $table->longText('organic_results')->nullable();
            $table->string('device')->nullable();
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
        Schema::dropIfExists('google_ads_keywords');
    }
};
