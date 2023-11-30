<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_statuses', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('colour_id') // The colour of the login status badge.
                ->nullable()
                ->constrained('colours')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('title');
            $table->text('description');
            $table->text('message');

            // Options.
            $table->boolean('can_login')->default(1); // 0 = Cannot Login / 1 = Can Login.
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
        Schema::dropIfExists('login_statuses');
    }
}
