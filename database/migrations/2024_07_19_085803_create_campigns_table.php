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
        Schema::create('campigns', function (Blueprint $table) {
            $table->id();
            $table->string('vertical')->nullable();
            $table->string('topic')->nullable();
            $table->string('keyword')->nullable();
            $table->text('topic_campaign_name')->nullable();
            $table->text('topic_domain_name')->nullable();
            $table->text('topic_offer_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campigns');
    }
};
