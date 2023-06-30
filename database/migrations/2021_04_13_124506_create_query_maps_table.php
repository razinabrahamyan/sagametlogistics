<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueryMapsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('query_maps', function (Blueprint $table) {
            $table->id();
            $table->text('data')
                  ->comment("Данные заявки");
            $table->string('status')
                  ->comment("Статус заявки");
            $table->integer('query_id')
                  ->comment("Id измененной заявки");
            $table->string('type')
                  ->comment("Тип мапинга");
            $table->integer('user_id')
                  ->comment("Пользователь который ввел изменения в заявку");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('query_maps');
    }
}
