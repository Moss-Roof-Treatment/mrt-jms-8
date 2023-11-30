<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteQuoteDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_quote_document', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Foreign keys.
            $table->foreignId('quote_document_id')
                ->constrained('quote_documents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_quote_document');
    }
}
