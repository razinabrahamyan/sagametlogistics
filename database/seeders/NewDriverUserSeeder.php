<?php

namespace Database\Seeders;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\RolesConstants;
use App\Classes\Constants\WhatsAppConstants;
use App\Classes\Helpers\GF;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewDriverUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drivers = Driver::whereNull('user_id')->get();

        foreach ($drivers as $driver) {
            $pass = self::randomPassword();
            $user = new User();
            $user->name = $driver->full_name;
            $user->email = "m1-logistics-$driver->id@gmail.com";
            $user->phone = GF::clearPhoneNumber($driver->phone);
            $user->password = bcrypt($pass);
            $user->role_id = RolesConstants::LOGISTIC_PERSONNEL;
            $user->save();

            $driver->update([
                'user_id' => $user->id,
            ]);

            foreach (WhatsAppConstants::NEW_DRIVER as $phone) {
                $message = "Мы запустили приложение для Логистики!\n\n";
                $message .= "Ссылка для Android - https://play.google.com/store/apps/details?id=com.garagejobs.m1logistics\n\n";
                $message .= "Ссылка для IPhone - https://apps.apple.com/ru/app/m1-logistics/id1607483725\n\n";
                $message .= "Водитель - $driver->full_name\n";
                $message .= "Почта - " . "m1-logistics-$driver->id@gmail.com\n";
                $message .= "Телефон - " . GF::clearPhoneNumber($driver->phone) . "\n";
                $message .= "Пароль - " . $pass;

                (new Api())->setBody($message)
                           ->setPhone($phone)
                           ->sendMessage();

//                (new Api())->setBody($message)
//                           ->setPhone($driver->phone)
//                           ->sendMessage();
                dd(1);
            }
        }
    }

    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
