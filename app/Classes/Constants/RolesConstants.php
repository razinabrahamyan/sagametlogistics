<?php


namespace App\Classes\Constants;


use App\Classes\Auth\AuthorizedUser;

class RolesConstants
{
    const ADMIN = 1;
    const LOGIST = 2;
    const MANAGER = 3;
    const LOGISTIC_PERSONNEL = 4;
    const RESPONSIBLE_FOR_DRIVERS = 5;

    /**
     * @return bool
     */
    public static function isAdmin() : bool
    {
        return AuthorizedUser::getRoleId() === self::ADMIN;
    }

    /**
     * @return bool
     */
    public static function isLogist() : bool
    {
        return AuthorizedUser::getRoleId() === self::LOGIST;
    }

    /**
     * @return bool
     */
    public static function isManager() : bool
    {
        return AuthorizedUser::getRoleId() === self::MANAGER;
    }

    /**
     * @return bool
     */
    public static function isLogisticPersonnel() : bool
    {
        return AuthorizedUser::getRoleId() === self::LOGISTIC_PERSONNEL;
    }

    public static function isResponsibleForDrivers(): bool
    {
        return AuthorizedUser::getRoleId() === self::RESPONSIBLE_FOR_DRIVERS;
    }
}