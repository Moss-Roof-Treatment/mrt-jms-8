<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteReminderResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_reminder_responses', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('reminder_response_status_id')
                ->default(1) // Pending.
                ->constrained('reminder_response_statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->text('response');
            $table->text('default_response')->nullable();
            $table->text('additional_text')->nullable();

            // Timestamps and Tokens
            $table->boolean('is_acknowledged')->default(0); // 0 = Bold, 1 = Not Bold.
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
        Schema::dropIfExists('quote_reminder_responses');
    }
}
