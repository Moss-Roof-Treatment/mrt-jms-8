<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('job_id')
                ->nullable()
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('quote_id')
                ->nullable()
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('quote_request_id')
                ->nullable()
                ->constrained('quote_requests')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('user_id') // The User Creating The Event.
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('staff_id') // The User Creating The Event.
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title'); // Title Of The Event.
            $table->text('description')->nullable(); // Description Of The Event.
            $table->string('color')->nullable(); // Label background colour of the event.
            $table->string('textColor')->nullable(); // Label text colour of the event.

            // Images.
            $table->text('image_paths')->nullable(); // The images of the quote tradespersons.

            // Options.
            $table->boolean('is_personal')->default(0); // If the event is personal.
            $table->boolean('is_tradesperson_confirmed')->default(0); // If the tradesperson has confirmed the real work date. 0 - not real work date, 1 - is real work date.

            // Timestamps.
            $table->dateTime('start')->nullable(); // Start Of The Event.
            $table->dateTime('end')->nullable(); // End Of The Event.
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
        Schema::dropIfExists('events');
    }
}
