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

            // Fields.
            $table->string('email')->nullable(); // User Email.
            $table->string('first_name')->nullable(); // User First Name.
            $table->string('last_name')->nullable(); // User Last Name.
            $table->string('street_address')->nullable(); // User Street Address.
            $table->string('suburb')->nullable(); // User Suburb.
            $table->string('postcode')->nullable(); // User Postcode.
            $table->string('home_phone')->nullable(); // User Home Phone.
            $table->string('mobile_phone')->nullable(); // User Mobile Phone.
            $table->string('business_name')->nullable(); // The Company that the User owns.
            $table->string('abn')->nullable(); // The Company that the User owns.
            $table->string('business_phone')->nullable(); // User business Phone.
            $table->text('description')->nullable(); // User business Phone.

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
