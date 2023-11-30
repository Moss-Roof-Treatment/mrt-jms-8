<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('equipment_category_id')
                ->nullable()
                ->constrained('equipment_categories')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('equipment_group_id')
                ->nullable()
                ->constrained('equipment_groups')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title'); // Name of the tool.
            $table->string('brand'); // Brand of the tool.
            $table->text('description'); // Description of the tool.
            $table->string('serial_number')->nullable(); // The serial number of the tool.

            // Images.
            $table->string('image_path')->nullable(); // Image of the tool.

            // Timestamps
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
        Schema::dropIfExists('equipment');
    }
}
