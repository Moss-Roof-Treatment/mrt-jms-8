<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_products', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->float('quantity')->nullable(); // Quantity of the product, this is not used in calculations, for labling only.
            $table->text('description')->nullable(); // A unique description or directions for this specific quote product only.
            $table->float('individual_price')->nullable(); // This value is for display purposes only, it is not used in calculations, for labling only.
            $table->integer('total_price')->nullable(); // The value used for the total cost of the quote product, it is not quantity times individual price.
            $table->float('price_per_litre'); // For Fuel Only - The price per litre that is locked in when the fuel quote product is created.
            $table->float('usage_per_100_kms'); // For Fuel Only - The usage per 100 kms that is locked in when the fuel quote product is created.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_products');
    }
}
