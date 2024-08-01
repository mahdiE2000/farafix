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
            Schema::create( 'users' , function ( Blueprint $table ) {
                $table->id();
                $table->string( 'name' );
                $table->string( 'cell_number' )->unique()->max( 20 );
                $table->string( 'password' );
                $table->enum( 'role' , [ "admin" , "user" ] )->default("user");
                $table->boolean( 'verified')->default(0);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( 'users' );
        }
    };
