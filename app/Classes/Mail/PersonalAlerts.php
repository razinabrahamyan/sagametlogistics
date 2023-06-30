<?php

namespace App\Classes\Mail;

class PersonalAlerts
{
    const ARTUR_EMAIL = 'artur.simonyan.job@gmail.com';
    const EDUARD_EMAIL = 'smnned@gmail.com';

    public static function alertArtur($subject, $message) : bool
    {
        return (new PHPMailerHandler())->setToAddresses([self::ARTUR_EMAIL])
                                       ->setSubject($subject)
                                       ->setMessage($message)
                                       ->send();
    }

    public static function alertEduard($subject, $message) : bool
    {
        return (new PHPMailerHandler())->setToAddresses([self::EDUARD_EMAIL])
                                       ->setSubject($subject)
                                       ->setMessage($message)
                                       ->send();
    }
}