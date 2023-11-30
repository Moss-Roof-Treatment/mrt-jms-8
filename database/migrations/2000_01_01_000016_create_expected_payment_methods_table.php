<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpectedPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expected_payment_methods', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('payment_type_id')
                ->nullable()
                ->constrained('payment_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('payment_method_id')
                ->nullable()
                ->constrained('payment_methods')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title')->unique();
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expected_payment_methods');
    }
}
