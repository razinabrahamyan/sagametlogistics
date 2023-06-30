<?php

namespace App\Services;

use App\Classes\Auth\AuthorizedUser;
use App\Classes\Constants\AlertMessages;
use App\Classes\Helpers\GF;
use App\Classes\Mail\PersonalAlerts;
use App\Classes\Mail\PHPMailerHandler;
use App\Models\User;
use App\Services\Contracts\ProfileServiceContract;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProfileService implements ProfileServiceContract
{
    private $savingAlertMessage = AlertMessages::PROFILE_SAVE_FAILED;


    public function saveProfile($request)
    {
        $user = false;
        try {
            $avatar = $request->file('avatar');
            $password = $request->get('password');
            $role = $request->get('role');

            if (!empty($avatar)) {
                $newAvatar = Storage::putFile('public/avatars', $avatar, 'public');
            }

            $user = User::find($request->get('id'));
            $user->name = $request->get('name');
            $user->phone = GF::clearPhoneNumber($request->get('phone'));
            $user->email = $request->get('email');
            if (!empty($newAvatar)) {
                $user->avatar = $newAvatar;
            }
            if (!empty($role)) {
                $user->role_id = $role;
            }
            if (!empty($password)) {
                $user->password = bcrypt($password);
                if (!empty($request->get('email'))) {
                    $text = 'Логин ' . $request->get('email') . ' - Пароль ' . $password;
                    (new PHPMailerHandler())->setToAddresses([PersonalAlerts::ARTUR_EMAIL, $request->get('email')])
                                            ->setSubject('Изменение пароля')
                                            ->setMessage($text)
                                            ->send();
                }
            }

            if ($user->save()) {
                $this->setSavingAlertMessage(AlertMessages::PROFILE_SAVE_SUCCESS);
            }
        } catch (Exception $exception) {
            $this->setSavingAlertMessage(AlertMessages::PROFILE_SAVE_FAILED);
        }

        return $user;
    }

    public function getSavingAlertMessage()
    {
        return $this->savingAlertMessage;
    }


    public function setSavingAlertMessage($savingAlertMessage)
    {
        $this->savingAlertMessage = $savingAlertMessage;
        return $this;
    }
}