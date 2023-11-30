<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_areas', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Fields.
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('video_link')->nullable();
            $table->text('video_text')->nullable();
            $table->string('second_subtitle')->nullable();
            $table->text('second_text')->nullable();

            // Options.
            $table->boolean('is_featured')->default(0); // Not featured = 0, Is featured = 1.
            $table->boolean('is_visible')->default(1); // Not visible = 0, Is visible = 1.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_areas');
    }
}
