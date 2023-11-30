<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_commission', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->nullable()
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('salesperson_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('invoice_id')
                ->nullable()
                ->constrained('invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->integer('quote_total')->default(0);
            $table->float('total_percent')->default(0);
            $table->float('individual_percent_value')->default(0);
            $table->integer('edited_total')->default(0);

            // Options.
            $table->dateTime('approval_date')->nullable(); // if this has been converted to a quote item or not.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_commission');
    }
}
