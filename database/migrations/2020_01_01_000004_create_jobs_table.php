<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            // Primary key.
            $table->id();

            // Foreign keys.
            $table->foreignId('customer_id') // The customer.
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('salesperson_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('job_status_id')
                ->nullable()
                ->constrained('job_statuses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('job_progress_id')
                ->nullable()
                ->constrained('job_progresses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('material_type_id')
                ->nullable()
                ->constrained('material_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('building_style_id')
                ->nullable()
                ->constrained('building_styles')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('building_type_id')
                ->nullable()
                ->constrained('building_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('inspection_type_id')
                ->nullable()
                ->constrained('inspection_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('follow_up_call_status_id')
                ->nullable()
                ->constrained('follow_up_call_statuses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('quote_sent_status_id')
                ->nullable()
                ->constrained('quote_sent_statuses')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('default_properties_to_view_id')
                ->nullable()
                ->constrained('default_properties_to_views')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Fields.
            $table->string('tenant_name');
            $table->string('tenant_home_phone')->nullable();
            $table->string('tenant_mobile_phone')->nullable();
            $table->string('tenant_street_address');
            $table->string('tenant_suburb');
            $table->string('tenant_postcode');
            $table->string('label')->nullable(); // label.

            // Options.
            $table->boolean('is_visable')->default(1); // 0 = Not visible / 1 = visible.
            $table->boolean('is_editable')->default(1); // 0 = Not Editable / 1 = Editable.
            $table->boolean('is_delible')->default(1); // 0 = Not Delible / 1 = Delible.

            // Timestamps.
            $table->dateTime('inspection_date')->nullable();
            $table->dateTime('sold_date')->nullable();
            $table->boolean('start_date_null')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('completion_date')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
