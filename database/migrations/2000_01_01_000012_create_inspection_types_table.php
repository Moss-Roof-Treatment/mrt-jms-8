<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_types', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('title');
            $table->text('description');

            // Options.
            $table->boolean('is_selectable')->default(1); // 0 = Not Selectable / 1 = Selectable.
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
        Schema::dropIfExists('inspection_types');
    }
}
