<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('name')->unique(); // Product name.
            $table->string('slug')->unique(); // Product url slug.
            $table->text('details')->nullable(); // Branding details and usage directions.
            $table->text('description'); // Product description.
            $table->integer('cost_price')->default(0); // Product cost price.
            $table->integer('profit_amount')->default(0); // Product profit price.
            $table->integer('postage_price')->default(0); // Product postage price.
            $table->integer('price')->default(0); // Product total price.
            $table->string('dimensions')->nullable(); // Dimentions.
            $table->double('weight')->nullable(); // Product total price.
            $table->string('document_path')->nullable(); // The MSDS.

            // Options.
            $table->boolean('is_visible')->default(0); // If the product is visable in the store / 0 = Not Visible / 1 = Visible.
            $table->boolean('is_selectable')->default(0); // If the item can be selected in quotes / 0 = Not Selectable / 1 = Selectable.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(1); // 0 = Not Delible / 1 = Delible.

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
        Schema::dropIfExists('products');
    }
}
