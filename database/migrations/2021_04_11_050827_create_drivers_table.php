<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->comment('ФИО водителя');
            $table->string('status')->comment('Статус водителей');
            $table->string('phone')->comment('Телефон водителя');
            $table->string('email')->nullable()->comment('Почта водителя');
            $table->string('car_numbers')->comment('Номера машины');
            $table->integer('type_id')->default(1)->comment('Тип водителя');
            $table->integer('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('drivers');
    }
}
