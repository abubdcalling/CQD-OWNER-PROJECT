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
        Schema::table('seo_data', function (Blueprint $table) {
            $table->longText('meta_description')->nullable()->change();
            $table->text('meta_keywords')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_data', function (Blueprint $table) {
            $table->longText('meta_description')->nullable()->change();
            $table->text('meta_keywords')->nullable()->change();
        });
    }
};
