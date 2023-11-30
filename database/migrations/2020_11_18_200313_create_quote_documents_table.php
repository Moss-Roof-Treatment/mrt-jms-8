<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_documents', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('task_type_id')
                ->nullable()
                ->constrained('task_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('task_id')
                ->nullable()
                ->constrained('tasks')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('material_type_id')
                ->nullable()
                ->constrained('material_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title');
            $table->text('description');

            // Images.
            $table->string('image_path')->nullable(); // An image of the pdf document.

            // Files.
            $table->string('document_path')->nullable(); // The pdf document.

            // Options.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(1); // 0 = Not Delible / 1 = Delible.
            $table->boolean('is_default')->default(0); // 0 = Not Default / 1 = Is Default.

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
        Schema::dropIfExists('quote_documents');
    }
}
