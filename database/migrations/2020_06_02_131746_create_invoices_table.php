<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->nullable()
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('user_id') // The staff member creating the invoice.
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('staff_id') // The staff member signing off on the invoice.
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('identifier')->nullable();
            $table->integer('subtotal')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('payg')->default(0);
            $table->integer('superannuation')->default(0);
            $table->integer('total')->default(0);
            $table->string('confirmation_number')->nullable();

            // Options.
            $table->boolean('is_group_paid')->default(0); // 0 = Was Not paid in a group / 1 = Was paid in a group.

            // Timestamps.
            $table->dateTime('finalised_date')->nullable();
            $table->dateTime('submission_date')->nullable();
            $table->dateTime('confirmed_date')->nullable();
            $table->dateTime('paid_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
