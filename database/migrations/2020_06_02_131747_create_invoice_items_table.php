<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('job_id')->nullable(); // This is only a title not a relationship.
            $table->float('total_hours')->nullable();
            $table->float('billable_hours')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('cost_total')->nullable();
            $table->text('description')->nullable();

            // Timestamps.
            $table->dateTime('completed_date')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
}
