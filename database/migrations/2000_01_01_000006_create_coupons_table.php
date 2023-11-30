<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('code')->unique();
            $table->string('type');
            $table->integer('value')->nullable();
            $table->integer('percent_off')->nullable();
            $table->text('description');

            // Options.
            $table->boolean('is_active')->default(1); // 0 = Not Active / 1 = Active.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(0); // 0 = Not Delible / 1 = Delible.

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
        Schema::dropIfExists('coupons');
    }
}
