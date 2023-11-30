<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingStylePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_style_posts', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('building_style_post_type_id')
                ->constrained('building_style_post_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('material_type_id')
                ->constrained('material_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('title')->unique();
            $table->text('description')->nullable();

            // Images.
            $table->string('roof_outline_image_path')->nullable();
            $table->string('building_image_path')->nullable();

            // Timestamps.
            $table->dateTime('completed_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_style_posts');
    }
}
