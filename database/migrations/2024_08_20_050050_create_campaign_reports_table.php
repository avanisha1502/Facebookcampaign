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
        Schema::create('campaign_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->string('report_id')->nullable();
            $table->string('campaign_id');
            $table->string('name');
            $table->string('account_id');
            $table->json('adsets')->nullable();
            $table->json('ads')->nullable();
            $table->integer('daily_budget')->nullable();
            $table->integer('reach')->nullable();
            $table->integer('impressions')->nullable();
            $table->float('ctr')->nullable();
            $table->float('cpc')->nullable();
            $table->float('cpm')->nullable();
            $table->float('spend')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_stop')->nullable();
            $table->string('inline_link_clicks')->nullable();
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
        Schema::dropIfExists('campaign_reports');
    }
};
