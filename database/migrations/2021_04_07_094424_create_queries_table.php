<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->index('queries_status_index')->comment('Статус заявки');
            $table->string('client_name')->comment('Имя клиента');
            $table->timestamp('departure_date')->comment('Время выезда к клиенту');
            $table->timestamp('base_departure_date')->nullable()->comment('Время выезда с базы');
            $table->string('phone')->comment('Номер телефона клиента');
            $table->tinyInteger('need_call_client')->nullable()->comment('Нужно ли позвонить клиенту');
            $table->tinyInteger('regular_client')->comment('Постоянный клиент');
            $table->string('address')->comment('Адрес клиента для выезда');
            $table->string('address_points')->comment('Координаты адреса клиента для выезда');
            $table->text('photos')->nullable()->comment('Фотографии металла клиента');
            $table->text('videos')->nullable()->comment('Видео металла клиента');
            $table->integer('type_of_metal')->comment('Тип металла');
            $table->integer('price')->comment('Озвученная цена');
            $table->string('weight')->comment('Вес метала');
            $table->string('weight_from')->nullable()->comment('Вес метала от');
            $table->string('weight_to')->nullable()->comment('Вес метала до');
            $table->integer('oxygen_count')->comment('Количество кислорода');
            $table->integer('loaders_count')->comment('Количество грузчиков');
            $table->integer('cutters_count')->comment('Количество резчиков');
            $table->text('machines')->comment('Типы машин');
            $table->string('machines_title')->nullable()->comment('Отображение машин для таблицы');
            $table->string('base_address')->default('Наша база')->comment('Выбор базы куда повезут метал');
            $table->tinyInteger('is_client_need_video')->comment('Нужно ли снять видео для клиента');
            $table->text('comment')->nullable()->comment('Комментарий для заявки');
            $table->string('user_id')->index('queries_user_index')->comment('id юзера который создал заявку');
            $table->string('access_token')->comment('Токен который нужен для preview заявки персоналом логистики');
            $table->string('scrap')->comment('Уровень засора');
            $table->softDeletes();
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
        Schema::dropIfExists('queries');
    }
}
