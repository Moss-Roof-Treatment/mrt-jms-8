<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_roles', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Fields.
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('route_title');

            // Options.
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
        Schema::dropIfExists('account_roles');
    }
}
