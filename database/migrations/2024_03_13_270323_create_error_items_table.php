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
        Schema::create( 'error_items' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedInteger( 'error_id' );
            $table->index( 'error_id' );
            $table->string( 'key' )->nullable();
            $table->text( 'value' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'error_items' );
    }
};
