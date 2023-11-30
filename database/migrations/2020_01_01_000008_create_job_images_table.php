<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_images', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('job_image_type_id')
                ->nullable()
                ->constrained('job_image_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('colour_id')
                ->default(1)
                ->constrained('colours')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->text('title')->nullable();
            $table->text('description')->nullable();

            // Images.
            $table->string('image_identifier')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_pdf_image')->default(0);

            // Options.
            $table->boolean('is_visible')->default(1);

            // Timestamps
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
        Schema::dropIfExists('job_images');
    }
}
