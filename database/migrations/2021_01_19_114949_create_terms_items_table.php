<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms_items', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('terms_sub_heading_id')
                ->constrained('terms_sub_headings')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->text('text');

            // Options.
            $table->boolean('is_editable')->default(1); // 0 = Cannot be edited, 1 = Can be edited.
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
        Schema::dropIfExists('terms_items');
    }
}
