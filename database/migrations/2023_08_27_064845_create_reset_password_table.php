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
            Schema::create( 'reset_passwords' , function ( Blueprint $table ) {
                $table->string( 'code' , 191 )->primary();
                $table->string( 'cell_number' )->index();
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists( 'reset_passwords' );
        }
    };
