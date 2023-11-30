<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('account_class_id')
                ->default(5) // Default - Individual.
                ->constrained('account_classes');

            $table->foreignId('account_role_id')
                ->default(5) // Default - Customer.
                ->constrained('account_roles');

            $table->foreignId('login_status_id')
                ->default(1) // Default - Has Access.
                ->constrained('login_statuses');

            $table->foreignId('referral_id')
                ->default(7) // Default - Not Registered.
                ->constrained('referrals');

            $table->foreignId('state_id')
                ->default(7) // Default - Victoria.
                ->constrained('states');

            // Fields.
            $table->string('username')->nullable(); // Username.
            $table->string('email')->nullable(); // User Email.
            $table->string('password'); // User Password.
            $table->string('first_name'); // User First Name.
            $table->string('last_name'); // User Last Name.
            $table->string('street_address'); // User Street Address.
            $table->string('suburb'); // User Suburb.
            $table->string('postcode'); // User Postcode.
            $table->string('home_phone')->nullable(); // User Contact Phone.
            $table->string('mobile_phone')->nullable(); // User Contact Mobile Phone.
            $table->text('user_description')->nullable(); // User business Description.
            $table->string('user_color')->default('#ffff00'); // If the User is subscribed to the Mailing List.
            $table->string('business_name')->nullable(); // The Company that the User owns.
            $table->string('abn')->nullable(); // The Company that the User owns.
            $table->string('business_phone')->nullable(); // User business Phone.
            $table->string('business_contact_phone')->nullable(); // User business Phone.
            $table->string('business_position')->nullable(); // The Company that the User owns.
            $table->string('bank_name')->nullable(); // The bank account number.
            $table->string('bank_bsb')->nullable(); // The bank bsb number.
            $table->string('bank_account_name')->nullable(); // The bank account number.
            $table->string('bank_account_number')->nullable(); // The bank account number.
            $table->text('business_description')->nullable(); // User business Description.

            $table->boolean('has_gst')->default(0);
            $table->boolean('has_payg')->default(0);
            $table->string('super_fund_name')->nullable();
            $table->string('super_member_numnber')->nullable();
            $table->string('workcover_company_name')->nullable();
            $table->boolean('has_commissions')->default(0); // If the user is getting commissions or not.

            $table->string('kin_name')->nullable(); // Next Of Kin First Name.
            $table->string('kin_address')->nullable(); // Next Of Kin Street Address.
            $table->string('kin_mobile_phone')->nullable(); // Next Of Kin Contact Mobile Phone.
            $table->string('kin_relationship')->nullable(); // Next Of Kin Relationship.

            // Images.
            $table->string('image_path')->nullable();
            $table->string('logo_path')->nullable();

            // Options.
            $table->boolean('is_subscribed_email')->default(1); // If the User is subscribed to receive email.
            $table->boolean('is_subscribed_sms')->default(1); // If the User is subscribed to receive sms.
            $table->boolean('has_login_details')->default(0); // If the customer has been sent their login details or not.
            $table->rememberToken();

            // Timestamps.
            $table->dateTime('last_login_date')->nullable();
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
        Schema::dropIfExists('users');
    }
}
