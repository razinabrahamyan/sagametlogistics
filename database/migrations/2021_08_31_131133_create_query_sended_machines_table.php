<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuerySendedMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_sended_machines', function (Blueprint $table) {
            $table->id();
            $table->integer('query_id')->index('query_id_index');
            $table->json('drivers_data');
            $table->integer('su_status')->default(1); //1-не отправлено в складской учет, 2- отправлено
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
        Schema::dropIfExists('query_sended_machines');
    }
}
