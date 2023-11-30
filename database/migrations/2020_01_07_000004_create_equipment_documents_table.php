<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_documents', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->string('title');
            $table->text('description')->nullable();

            // Images.
            $table->string('image_path')->nullable();

            // Documents.
            $table->string('document_path')->nullable();

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
        Schema::dropIfExists('equipment_documents');
    }
}
