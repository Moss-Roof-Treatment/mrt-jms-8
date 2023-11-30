<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('article_category_id')
                ->nullable()
                ->constrained('article_categories')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->unsignedInteger('type'); // 1 = article, 2 = blog
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle');
            $table->text('text');
            $table->string('location')->nullable();

            // Options.
            $table->boolean('is_visible');

            // Timestamps.
            $table->dateTime('completed_date')->nullable();
            $table->dateTime('published_date')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
