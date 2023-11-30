<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Fields.
            $table->string('title');
            $table->string('subject')->nullable();
            $table->text('text')->nullable();
            $table->text('class_name'); // The name of the mail class.

            // Options.
            $table->boolean('is_groupable')->default(1); // 0 = Cannot be a group email, 1 = Can be a group email.
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
        Schema::dropIfExists('email_templates');
    }
}
