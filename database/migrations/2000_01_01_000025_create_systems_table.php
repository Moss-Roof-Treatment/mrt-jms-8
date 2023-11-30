<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('title')->unique(); // Name of the company.
            $table->string('short_title'); // Name of the company.
            $table->text('description')->nullable(); // Short description of the company.
            $table->string('acronym')->unique(); // Unique - 2 digit code of the company.
            $table->string('bank_name'); // Nullable - The bank name.
            $table->string('bank_account_name'); // Nullable - The BSB number of the company.
            $table->string('bank_account_number'); // Nullable - The bank account number of the company.
            $table->string('bank_bsb_number'); // Nullable - The BSB number of the company.
            $table->string('contact_name'); // Contact front of home phone name of the company.
            $table->string('contact_address'); // Contact front of house address of the company.
            $table->string('contact_phone'); // Contact front of home phone number of the company.
            $table->string('default_sms_phone'); // Default number used when sending sms messages.
            $table->string('contact_email'); // Contact Email of the company.
            $table->string('website_url'); // Public facing website of the company.
            $table->string('abn'); // Australian Business Number.
            $table->float('default_tax_value')->nullable(); // GST.
            $table->float('default_superannuation_value')->nullable(); // Superannuation.
            $table->float('default_total_commission')->nullable(); // default commission percentage of total quote.
            $table->integer('default_petrol_price')->nullable(); // default petrol price per litre.
            $table->float('default_petrol_usage')->nullable(); // default litres per 100 kms.

            // Images.
            $table->string('logo_path')->nullable(); // Highlighted colour of the company - for calendar.
            $table->string('letterhead_path')->nullable(); // Highlighted colour of the company - for calendar.

            // Options.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.

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
        Schema::dropIfExists('systems');
    }
}
