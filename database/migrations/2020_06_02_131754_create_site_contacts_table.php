<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_contacts', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('name');
            $table->string('email');
            $table->string('contact_phone')->nullable();
            $table->string('street_address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('postcode')->nullable();
            $table->text('text');
            $table->string('user_agent'); // Users Browser info
            $table->string('ip_address'); // User IP Address
            $table->string('referrer'); // Website Referrer

            // Options
            $table->boolean('is_spam')->default(0);

            // Timestamps.
            $table->dateTime('seen_at')->nullable();
            $table->dateTime('acknowledged_at')->nullable();
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
        Schema::dropIfExists('site_contacts');
    }
}
