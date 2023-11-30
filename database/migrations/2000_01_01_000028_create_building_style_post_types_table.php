<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingStylePostTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_style_post_types', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('title')->unique();
            $table->string('slug')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();

            // Images.
            $table->string('image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_style_post_types');
    }
}
