<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->nullable();;
            $table->index( 'category_id' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
