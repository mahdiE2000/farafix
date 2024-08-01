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
        Schema::create( 'blogs' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedInteger( 'category_id' );
            $table->index( 'category_id' );
            $table->string( 'title' )->nullable();
            $table->text( 'summary' )->nullable();
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
        Schema::dropIfExists( 'blogs' );
    }
};
