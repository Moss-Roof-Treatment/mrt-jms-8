<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('order_name');
            $table->string('order_address');
            $table->string('order_suburb');
            $table->string('order_postcode');
            $table->string('order_email');
            $table->string('order_home_phone')->nullable();
            $table->string('order_mobile_phone')->nullable();
            $table->string('receipt_identifier');
            $table->string('order_name_on_card');
            $table->string('order_discount')->nullable();
            $table->string('order_discount_code')->nullable();
            $table->integer('order_subtotal');
            $table->integer('order_tax');
            $table->integer('order_total');
            $table->string('payment_gateway')->default('Stripe');
            $table->boolean('has_processing_fee')->default(0);
            $table->string('error')->nullable();
            $table->string('courier_company_name')->nullable(); // The receipt / tracking number from the courier.
            $table->string('postage_confirmation_number')->nullable(); // The receipt / tracking number from the courier.

            // Timestamps.
            $table->dateTime('confirmation_date')->nullable(); // The date a staff member has confirmed the order has arrived and is without errors. 
            $table->dateTime('postage_date')->nullable(); // The date the the products have been posted.
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
        Schema::dropIfExists('orders');
    }
}
