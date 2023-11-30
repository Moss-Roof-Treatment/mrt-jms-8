<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultEmailResponseTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_email_response_texts', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->text('text');

            // Options.
            $table->boolean('type'); // 0 = Waiting, 1 = Do no proceed.
            $table->boolean('is_selectable')->default(1); // 0 = Cannot be selected, 1 = Can be selected.
            $table->boolean('is_editable')->default(1); // 0 = Cannot be edited, 1 = Can be edited.
            $table->boolean('is_delible')->default(1); // 0 = Cannot be deleted, 1 = Can be deleted.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_email_response_texts');
    }
}
