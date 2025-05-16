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
        Schema::table('incomplete_applications', function (Blueprint $table) {
            $table->integer('reminder_count')->default(0);
            $table->foreignId('package_id')->nullable()->constrained('packages')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomplete_applications', function (Blueprint $table) {
            $table->dropForeign('incomplete_applications_package_id_foreign');
            $table->dropColumn('package_id');
            $table->dropColumn('reminder_count');
        });
    }
};
