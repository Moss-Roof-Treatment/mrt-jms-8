<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('quote_id')
                ->nullable()
                ->constrained('quotes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('tradesperson_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Timestamp.
            $table->boolean('jms_is_acknowledged')->default(0);
            $table->boolean('tradesperson_is_acknowledged')->default(0);
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
        Schema::dropIfExists('surveys');
    }
}
