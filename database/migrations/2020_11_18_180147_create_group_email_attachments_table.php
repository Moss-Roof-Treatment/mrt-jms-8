<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_email_attachments', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('group_email_id')
                ->nullable()
                ->constrained('group_emails')
                ->onUpdate('cascade')
                ->onDelete('set null'); // Set null due to the image in storage.

            // Fields.
            $table->string('title');

            // Images.
            $table->string('storage_path');

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
        Schema::dropIfExists('group_email_attachments');
    }
}
