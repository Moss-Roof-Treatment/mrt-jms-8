<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_contacts', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->text('text')->nullable();

            // Timestamps.
            $table->timestamp('call_back_date')->nullable();
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
        Schema::dropIfExists('lead_contacts');
    }
}
