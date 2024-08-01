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
        Schema::create( 'product_variations' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedInteger( 'product_id' );
            $table->index( 'product_id' );
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
        Schema::dropIfExists( 'product_variations' );
    }
};
