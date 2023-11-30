<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_replies', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('message_id')
                ->constrained('messages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('sender_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->text('text'); // The content of the message response.
            $table->boolean('is_visible')->default(1); // The content of the message response - Not visible = 0, Is visible = 1.

            // Timestamps.
            $table->softDeletes();
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
        Schema::dropIfExists('message_replies');
    }
}
