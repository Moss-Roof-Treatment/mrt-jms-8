<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwmsQuestionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swms_question_categories', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Fields.
            $table->string('title')->unique();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('swms_question_categories');
    }
}
