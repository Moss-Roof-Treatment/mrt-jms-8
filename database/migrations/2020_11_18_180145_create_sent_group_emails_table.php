<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentGroupEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_group_emails', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('group_email_id')
                ->constrained('group_emails')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('job_id')
                ->nullable()
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('name');
            $table->string('recipient');
            $table->boolean('response')->nullable();
            $table->text('response_text')->nullable();
            $table->text('internal_comment')->nullable();

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
        Schema::dropIfExists('sent_group_emails');
    }
}
