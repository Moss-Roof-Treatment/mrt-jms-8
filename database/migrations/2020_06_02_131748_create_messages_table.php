<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('sender_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('recipient_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('priority_id')
                ->constrained('priorities')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->text('text'); // The content of the message.

            // Timestamps.
            $table->dateTime('recipient_seen_at')->nullable(); // If the recipient has seen the note.
            $table->dateTime('sender_seen_at')->nullable(); // If the recipient has seen the note.
            $table->dateTime('jms_seen_at')->nullable(); // If the admin has seen the note.
            $table->dateTime('sender_is_visible')->nullable(); // If the sender has soft deleted the note.
            $table->dateTime('recipient_is_visible')->nullable(); // If the recipient has soft deleted the note.
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
        Schema::dropIfExists('messages');
    }
}
