<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobJobTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_job_type', function (Blueprint $table) {
            // Primary key.  
            $table->id();

            // Foreign keys.
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('job_type_id')
                ->constrained('job_types')
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
        Schema::dropIfExists('job_job_type');
    }
}
