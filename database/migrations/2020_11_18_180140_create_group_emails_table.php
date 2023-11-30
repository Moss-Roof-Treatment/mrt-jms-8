<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_emails', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('email_user_group_id')
                ->nullable()
                ->constrained('email_user_groups')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('email_template_id')
                ->nullable()
                ->constrained('email_templates')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('subject');
            $table->text('text');
            $table->text('internal_comment')->nullable();

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
        Schema::dropIfExists('group_emails');
    }
}
