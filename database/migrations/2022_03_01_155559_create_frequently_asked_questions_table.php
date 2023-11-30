<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequentlyAskedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequently_asked_questions', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->text('question');
            $table->text('answer');

            // Options.
            $table->boolean('is_visible')->default(0); // If the item is visable on the site / 0 = Not Visible / 1 = Visible.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frequently_asked_questions');
    }
}
