<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('salesperson_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('referral_id')
                ->nullable()
                ->constrained('referrals')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('state_id')
                ->default(7) // Default - Victoria.
                ->constrained('states')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('account_class_id')
                ->default(5) // Default - Individual.
                ->constrained('account_classes');

            $table->foreignId('lead_status_id')
                ->default(1) // Default - New.
                ->constrained('lead_statuses');

            // Fields.
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('street_address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('postcode')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('abn')->nullable();
            $table->string('business_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();

            // Options
            $table->boolean('do_not_contact')->default(0); // 0 - Contact / 1 - Do not contact.

            // Timestamps.
            $table->dateTime('call_back_date')->nullable(); // the date time the customer requests to be call back.
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
        Schema::dropIfExists('leads');
    }
}
