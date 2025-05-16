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
        Schema::create('business_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('type');
            $table->string('industry');
            $table->integer('number_of_employees');
            $table->string('website')->nullable();
            $table->string('address');
            $table->text('business_description');
            $table->string('service_type');
            $table->text('service_description');
            $table->boolean('is_share')->default(true);
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_details');
    }
};
