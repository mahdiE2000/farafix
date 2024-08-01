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
            Schema::create( "addresses" , function ( Blueprint $table ) {
                $table->increments( 'id' );
                $table->unsignedInteger( 'city_id' )->nullable();
                $table->index( 'city_id' );
                $table->string( 'postal_code' )->nullable();
                $table->string('phone')->nullable()->max(20);
                $table->text('address')->nullable();
                $table->unsignedInteger( 'addressable_id' );
                $table->index( 'addressable_id' );
                $table->string( 'addressable_type' , 100 );
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( "addresses" );
        }
    };
