<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwmsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swms_questions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign keys.
            $table->foreignId('swms_question_category_id')
                ->constrained('swms_question_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('question');

            // Options.
            $table->boolean('is_selectable')->default(1); // 0 = Not Selectable / 1 = Is Selectable.
            $table->boolean('is_editable')->default(0); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(0); // 0 = Not Delible / 1 = Delible.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swms_questions');
    }
}
