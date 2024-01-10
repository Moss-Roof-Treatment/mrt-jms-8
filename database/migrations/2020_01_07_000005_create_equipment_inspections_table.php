<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_inspections', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('inspection_company')->nullable(); // The business name of who is performing the inspection.
            $table->string('inspector_name')->nullable(); // The name of the person who is performing the inspection.
            $table->string('tag_and_test_id')->nullable(); // The tag and test id of the inspection.
            $table->text('text')->nullable(); // Comments of the inspection.

            // Timestamps.
            $table->dateTime('inspection_date')->nullable(); // The date of the inspection.
            $table->dateTime('next_inspection_date')->nullable(); // The date of the next inspection. 
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
        Schema::dropIfExists('equipment_inspections');
    }
}
