<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('task_type_id')
                ->nullable()
                ->constrained('task_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('building_style_id')
                ->nullable()
                ->constrained('building_styles')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('building_type_id')
                ->nullable()
                ->constrained('building_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('dimension_id')
                ->nullable()
                ->constrained('dimensions')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('material_type_id')
                ->nullable()
                ->constrained('material_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title')->unique();
            $table->text('procedure');
            $table->text('description');
            $table->integer('price');

            // Images.
            $table->string('image_path')->nullable();

            // Options.
            $table->boolean('uses_product')->default(1); // 0 = Does Not Use Product / 1 = Does Use Product.
            $table->boolean('is_quote_visible')->default(1); // 0 = Not Quote Visible / 1 = Quote Visible.
            $table->boolean('is_selectable')->default(1); // 0 = Cannot be selected, 1 = Can be selected.
            $table->boolean('is_editable')->default(0); // 0 = Cannot be edited, 1 = Can be edited.
            $table->boolean('is_delible')->default(0); // 0 = Cannot be deleted, 1 = Can be deleted.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
