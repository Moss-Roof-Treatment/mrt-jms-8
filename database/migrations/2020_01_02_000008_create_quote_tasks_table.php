<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_tasks', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Fields.
            $table->integer('quantity')->default(1);
            $table->integer('pitch')->default(0);
            $table->text('description')->nullable();
            $table->integer('individual_price')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('total_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_tasks');
    }
}
