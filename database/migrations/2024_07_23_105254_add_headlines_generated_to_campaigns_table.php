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
        Schema::table('campigns', function (Blueprint $table) {
            $table->boolean('headlines_generated')->default(false)->after('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campigns', function (Blueprint $table) {
            $table->dropColumn('headlines_generated');
        });
    }
};
