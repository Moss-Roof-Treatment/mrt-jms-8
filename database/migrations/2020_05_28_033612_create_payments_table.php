<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('staff_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('payment_type_id')
                ->constrained('payment_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->integer('payment_amount');
            $table->integer('remaining_amount')->nullable();
            $table->boolean('has_processing_fee')->default(0);

            // Timestamps.
            $table->dateTime('payment_date'); // The date that the payment was made not the date it was entered.
            $table->dateTime('void_date')->nullable(); // If not null the payment is void.
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
        Schema::dropIfExists('payments');
    }
}
