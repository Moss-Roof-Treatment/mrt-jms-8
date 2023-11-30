<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('job_id')
                ->nullable()
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('quote_id')
                ->nullable()
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('event_id')
                ->nullable()
                ->constrained('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('equipment_id')
                ->nullable()
                ->constrained('equipment')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
                ->nullable()
                ->constrained('priorities')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->text('text'); // The content of the note.
            $table->boolean('is_internal')->default(0); // If the note is private.

            // Options.
            $table->boolean('profile_job_can_see')->default(0); // 0 = Was Not paid in a group / 1 = Was paid in a group.

            // Timestamps.
            $table->dateTime('recipient_seen_at')->nullable(); // If the recipient has seen the note.
            $table->dateTime('recipient_acknowledged_at')->nullable(); // If the recipient has acknowledged the note.
            $table->dateTime('jms_seen_at')->nullable(); // If the admin has seen the note.
            $table->dateTime('jms_acknowledged_at')->nullable(); // If the admin has acknowledged the note.
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
        Schema::dropIfExists('notes');
    }
}
