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
            Schema::create( "sms_batch" , function ( Blueprint $table ) {
                $table->increments( 'id' );
                $table->string( 'category' );
                $table->string( 'operator' , 100 );
                $table->enum( 'type' , [ 'service' , 'simcard' , 'advertise' ] );
                $table->string( 'code' , 40 );
                $table->string( 'pattern' )->nullable();
                $table->boolean( 'is_admin' )->default( 0 );
                $table->boolean( 'is_systematic' )->default( 0 );
                $table->string( 'from' )->nullable();
                $table->softDeletes();
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( "sms_batch" );
        }
    };
