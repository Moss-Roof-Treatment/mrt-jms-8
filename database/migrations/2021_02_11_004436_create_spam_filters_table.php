<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpamFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spam_filters', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->text('message'); // Users Browser info
            $table->string('user_agent'); // Users Browser info
            $table->string('ip_address')->unique(); // User IP Address
            $table->string('referrer'); // Website Referrer

            // Options.
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('spam_filters');
    }
}
