<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenericSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generic_sms', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('recipient_id') // The customer.
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('sender_id') // The staff member.
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('job_id') // The customer.
                ->nullable()
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('recipient_name');
            $table->string('mobile_phone');
            $table->text('text');
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('generic_sms');
    }
}
