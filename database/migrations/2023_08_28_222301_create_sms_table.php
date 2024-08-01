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
            Schema::create( "sms" , function ( Blueprint $table ) {
                $table->increments( 'id' );
                $table->unsignedBigInteger( 'client_id' )->nullable();
                $table->string( 'status' );
                $table->string( 'message' , 100 );
                $table->unsignedInteger( 'rel_id' );
                $table->string( 'rel_type' , 50 );
                $table->string( 'cell_number' , 20 );
                $table->unsignedInteger( 'fee' )->default( 0 );
                $table->unsignedInteger( 'sms_batch_id' );
                $table->index( 'sms_batch_id' );
                $table->integer( 'segment_count' )->nullable();
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( "sms" );
        }
    };
