<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('email_id')
                ->nullable()
                ->constrained('emails')
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
        Schema::dropIfExists('email_attachments');
    }
}
