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
        Schema::table('error_items', function (Blueprint $table) {
            // حذف ستون‌های error_id، key و value
            $table->dropColumn(['key', 'value']);
            // اضافه کردن ستون‌های name، title، title_en، summary و description
            $table->string('name')->unique();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('error_items', function (Blueprint $table) {
            // برگرداندن تغییرات
            $table->string('key')->nullable();
            $table->text('value')->nullable();
            $table->dropColumn(['name', 'title', 'title_en', 'summary', 'description']);
        });
    }
};
