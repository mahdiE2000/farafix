<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFakeModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fake_models', function (Blueprint $table) {
            $table->string('model_name')->nullable()->after('batch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fake_models', function (Blueprint $table) {
            $table->dropColumn('model_name');
            $table->dropTimestamps();
        });
    }
}
