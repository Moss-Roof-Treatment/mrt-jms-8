<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentInspectionImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_inspection_images', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('equipment_inspection_id')
                ->constrained('equipment_inspections')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->Text('description')->nullable();

            // Images.
            $table->string('image_path');

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
        Schema::dropIfExists('equipment_inspection_images');
    }
}
