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
        Schema::table('errors', function (Blueprint $table) {
            // حذف ستون‌های summary و title_en
            $table->dropColumn('summary');
            // اضافه کردن ستون date بعد از ستون title
            $table->dateTime('date')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('errors', function (Blueprint $table) {
            // برگرداندن تغییرات
            $table->text('summary')->nullable();
            $table->dropColumn('date');
        });
    }
};
