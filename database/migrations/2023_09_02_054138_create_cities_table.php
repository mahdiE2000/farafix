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
            Schema::create( 'cities' , function ( Blueprint $table ) {
                $table->id();
                $table->string( 'name_fa' );
                $table->string( 'name_en' );
                $table->double( 'latitude' )->nullable();
                $table->double( 'longitude' )->nullable();
                $table->boolean( 'view' );
                $table->unsignedInteger( 'parent_id' )->nullable();
                $table->index( 'parent_id' );
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( 'cities' );
        }
    };