<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsRecipientGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_recipient_groups', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Fields.
            $table->string('title'); // Title of the email user group
            $table->text('description')->nullable(); // Description of the email user group.
            $table->string('users_array')->nullable(); // Array of all user id's in the email user group.

            // Timestamps.
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
        Schema::dropIfExists('sms_recipient_groups');
    }
}
