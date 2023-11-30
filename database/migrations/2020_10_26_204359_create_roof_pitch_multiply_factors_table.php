<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoofPitchMultiplyFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roof_pitch_multiply_factors', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->integer('min')->unique();
            $table->integer('max')->unique();
            $table->double('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roof_pitch_multiply_factors');
    }
}
