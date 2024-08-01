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
        Schema::table('error_categories', function (Blueprint $table) {
            // حذف ستون‌های title و title_en
            $table->dropColumn(['title', 'title_en']);
            // اضافه کردن ستون name_en
            $table->string('name_en')->nullable()->after('name');
            // حذف ستون‌های date و description
            $table->dropColumn(['date', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('error_categories', function (Blueprint $table) {
            // برگرداندن تغییرات
            $table->string('title')->nullable()->after('name');
            $table->string('title_en')->nullable()->after('title');
            $table->dropColumn('name_en');
            $table->dateTime('date')->nullable();
            $table->text('description')->nullable();
        });
    }
};
