<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_rates', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('rate_id')
                ->constrained('rates')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->float('quantity')->nullable();
            $table->text('description')->nullable();
            $table->integer('individual_price')->nullable();
            $table->integer('total_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_rates');
    }
}
