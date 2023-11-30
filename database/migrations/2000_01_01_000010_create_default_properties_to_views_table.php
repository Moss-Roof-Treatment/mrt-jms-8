<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultPropertiesToViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_properties_to_views', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('title')->unique();
            $table->text('property_1');
            $table->text('property_2');
            $table->text('property_3');
            $table->text('property_4');

            // Options.
            $table->boolean('is_selectable')->default(1); // 0 = Cannot be selected, 1 = Can be selected.
            $table->boolean('is_editable')->default(1); // 0 = Cannot be edited, 1 = Can be edited.
            $table->boolean('is_delible')->default(1); // 0 = Cannot be deleted, 1 = Can be deleted.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_properties_to_views');
    }
}
