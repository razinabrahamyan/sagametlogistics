<?php


namespace App\Classes\Constants;


class AlertMessages
{
    //ЗАЯВКИ
    const QUERY_CREATED = "Заявка успешно создана";
    const QUERY_CREATING_ERROR = "Ошибка при создании заявки";
    const QUERY_UPDATED = "Заявка успешно обновлена";
    const QUERY_UPDATE_ERROR = "Ошибка при обновлении заявки";
    const QUERY_DELETED = "Заявка удалена";

    //WHATS-APP
    const WHATS_APP_SUCCESS_SEND = "Сообщение успешно отправлено";
    const WHATS_APP_ERROR_SEND = "Не удалось отправить сообщение";
    const WHATS_APP_ERROR_STATUS = "Нельзя отправить сообщение в текущем статусе заявки";

    //СТАТУСЫ
    const STATUS_CHANGE_SUCCESS = "Статус успешно изменен";
    const STATUS_CHANGE_FAILED = "Не удалось изменить статус";

    //Профиль
    const PROFILE_SAVE_SUCCESS = "Личные данные обновлены";
    const PROFILE_SAVE_FAILED = "Не удалось сохранить личные данные";

    //Водители
    const DRIVER_INFO_CHANGE_SUCCESS = "Личные данные обновлены";
    const DRIVER_STORE_SUCCESS = "Водитель добавлен";

    //Доступы
    const ACCESS_DENIED = 'Недостаточно прав';
}