<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generate_headlines', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->integer('campaign_id');
            $table->text('language');
            $table->text('headline');
            $table->text('primary_text');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_headlines');
    }
};
