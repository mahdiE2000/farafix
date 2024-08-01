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
        Schema::create('error_brand_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('error_brand_id');
            $table->unsignedBigInteger('error_category_id');
            $table->timestamps();

            $table->foreign('error_brand_id')->references('id')->on('error_brands')->onDelete('cascade');
            $table->foreign('error_category_id')->references('id')->on('error_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_brand_category');
    }
};
