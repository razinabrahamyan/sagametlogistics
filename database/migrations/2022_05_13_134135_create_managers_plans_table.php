<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('all_calls_plan')->default(0)->nullable();
            $table->integer('incoming_calls_plan')->default(0)->nullable();
            $table->integer('outgoing_calls_plan')->default(0)->nullable();
            $table->integer('all_calls')->default(0)->nullable();
            $table->integer('incoming_calls')->default(0)->nullable();
            $table->integer('outgoing_calls')->default(0)->nullable();
            $table->smallInteger('manager_id')->index('managers_plans_manager_id_index');
            $table->smallInteger('managers_calendar_id')->index('managers_plans_managers_calendar_id_index');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers_plans');
    }
}
