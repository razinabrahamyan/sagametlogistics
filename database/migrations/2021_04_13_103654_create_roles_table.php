<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("title")
                  ->comment("Наименование роли");
            $table->string("title_en")
                  ->nullable()
                  ->comment("Наименование роли на анлийском");
            $table->integer("status")
                  ->default(1)
                  ->comment("Статус активности \n 1 - Активный \n 0-Не активный");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('roles');
    }
}
