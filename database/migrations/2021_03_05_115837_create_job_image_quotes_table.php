<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobImageQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_image_quote', function (Blueprint $table) {
            // Primary key.  
            $table->id();

            // Foreign keys.
            $table->foreignId('job_image_id')
                ->constrained('job_images')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_image_quote');
    }
}
