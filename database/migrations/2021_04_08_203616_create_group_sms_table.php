<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_sms', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys.
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('sms_recipient_group_id')
                ->nullable()
                ->constrained('sms_recipient_groups')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('sms_template_id')
                ->nullable()
                ->constrained('sms_templates')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->text('text');
            $table->text('users_array')->nullable();
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
        Schema::dropIfExists('group_sms');
    }
}
