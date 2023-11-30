<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('survey_id')
                ->constrained('surveys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('survey_question_id')
                ->constrained('survey_questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
}
