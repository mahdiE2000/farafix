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
        Schema::create( 'error_categories' , function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->nullable();
            $table->string( 'title' )->nullable();
            $table->string( 'title_en' )->nullable();
            $table->dateTime( 'date' )->nullable();
            $table->text( 'description' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'error_categories' );
    }
};
