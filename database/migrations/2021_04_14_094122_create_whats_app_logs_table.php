<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsAppLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('whats_app_logs', function (Blueprint $table) {
            $table->id();
            $table->text('request');
            $table->text('response');
            $table->string('method');
            $table->text('error');
            $table->string('phone');
            $table->integer('query_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('whats_app_logs');
    }
}
