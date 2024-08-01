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
            Schema::create( 'requests' , function ( Blueprint $table ) {
                $table->id();
                $table->unsignedInteger( 'user_id' );
                $table->index( 'user_id' );
                $table->unsignedInteger( 'device_category_id' )->nullable();
                $table->string( 'device_title' )->nullable();
                $table->text( 'description' )->nullable();
                $table->enum( 'status' , [ 'approved' , 'rejected' , 'suspended' ] )->default( 'suspended' );
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( 'requests' );
        }
    };
