<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentGroupSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_group_sms', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('group_sms_id')
                ->constrained('group_sms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('name'); // The name used on the sms.
            $table->string('recipient'); // The mobile phone number.
            $table->boolean('response')->nullable(); // The response selected on the form from a link in the sms.
            $table->text('response_text')->nullable(); // The response entered into a form from a link in the sms.
            $table->text('internal_comment')->nullable(); // Optional internal comment from staff.

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
        Schema::dropIfExists('sent_group_sms');
    }
}
