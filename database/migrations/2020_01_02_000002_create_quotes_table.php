<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('customer_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('job_type_id')
                ->nullable()
                ->constrained('job_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('quote_status_id')
                ->nullable()
                ->constrained('quote_statuses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('expected_payment_method_id')
                ->default(1)
                ->constrained('expected_payment_methods')
                ->onUpdate('cascade');

            // Fields.
            $table->string('quote_identifier')->nullable();
            $table->integer('profit_margin')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('contracted_total')->default(0);
            $table->string('mpa_coverage')->default(1);
            $table->text('additional_comments')->nullable();
            $table->text('tax_invoice_discount')->default(0);
            $table->text('tax_invoice_note')->nullable();
            $table->integer('customer_view_count')->default(0);
            $table->text('description')->nullable();

            // Options.
            $table->boolean('deposit_emailed')->default(0); // 0 = Not Emailed / 1 = Emailed.
            $table->boolean('deposit_posted')->default(0); // 0 = Not Posted / 1 = Posted.
            $table->boolean('tax_invoice_emailed')->default(0); // 0 = Not Emailed / 1 = Emailed.
            $table->boolean('tax_invoice_posted')->default(0); // 0 = Not Posted / 1 = Posted.
            $table->boolean('final_receipt_emailed')->default(0); // 0 = Not Emailed / 1 = Emailed.
            $table->boolean('final_receipt_posted')->default(0); // 0 = Not Posted / 1 = Posted.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(1); // 0 = Not Delible / 1 = Delible.
            $table->boolean('is_sendable')->default(1); // 0 = Not Sendable / 1 = Sendable. Quote Reminder Email.
            $table->boolean('allow_early_receipt')->default(0); // 0 = Not Allowed / 1 = Allowed.
            $table->boolean('allow_accept_card_payment')->default(0); // 0 = Not Allowed / 1 = Allowed.

            // Timestamps.
            $table->dateTime('original_finalised_date')->nullable();
            $table->dateTime('finalised_date')->nullable();
            $table->dateTime('deposit_accepted_date')->nullable();
            $table->dateTime('remaining_balance_accepted_date')->nullable();
            $table->dateTime('tax_invoice_date')->nullable();
            $table->dateTime('final_receipt_date')->nullable();
            $table->dateTime('completion_date')->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
