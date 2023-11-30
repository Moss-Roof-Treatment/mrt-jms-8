<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('staff_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields
            $table->string('title');
            $table->text('description');

            // Images.
            $table->string('image_path')->nullable();

            // Timestamps.
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
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
        Schema::dropIfExists('qualifications');
    }
}
