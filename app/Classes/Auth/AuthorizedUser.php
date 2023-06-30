<?php


namespace App\Classes\Auth;


use Illuminate\Support\Facades\Storage;

class AuthorizedUser
{
    /**
     * Возвращает Id роли авторизованного пользователя
     * @return int
     */
    public static function getRoleId(): int
    {
        return auth()->user()->role->id ?? 0;
    }

    /**
     * Возвращает Id авторизованного пользователя
     * @return int
     */
    public static function getUserId(): int
    {
        return auth()->id() ?? 0;
    }

    /**
     * Возвращает имя авторизованного пользователя
     * @return string
     */
    public static function getUserName(): string
    {
        return auth()->user()->name ?? "";
    }

    /**
     * Возвращает наименование роли авторизованного пользователя
     * @return string
     */
    public static function getUserRoleTitle(): string
    {
        return auth()->user()->role->title ?? "";
    }

    /**
     * Возвращает путь к аватару авторизованного пользователя
     * @return string
     */
    public static function getUserAvatar(): string
    {
        return env('APP_URL') . (!empty(auth()->user()->avatar) ? '/storage/' . auth()->user()->avatar : '/images/avatars/default_avatar.png');
    }

    /**
     * Возвращает номер авторизованного пользователя
     * @return string
     */
    public static function getUserPhone(): string
    {
        return auth()->user()->phone ?? "";
    }

    /**
     * Возвращает почту авторизованного пользователя
     * @return string
     */
    public static function getUserMail(): string
    {
        return auth()->user()->email ?? "";
    }
}