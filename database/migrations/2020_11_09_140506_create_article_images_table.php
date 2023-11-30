<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_images', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign keys.
            $table->foreignId('article_id')
                ->constrained('articles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('staff_id')
                ->nullable()    
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->text('description')->nullable();
            $table->string('alt_tag_label')->nullable();

            // Images.
            $table->string('image_path');

            // Options.
            $table->boolean('is_visible')->default(1);
            $table->boolean('is_featured')->default(0);

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
        Schema::dropIfExists('article_images');
    }
}
