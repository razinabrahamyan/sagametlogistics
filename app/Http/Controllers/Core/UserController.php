<?php

namespace App\Http\Controllers\Core;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\RolesConstants;
use App\Classes\Constants\WhatsAppConstants;
use App\Classes\Helpers\GF;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Machine;
use App\Models\Role;
use App\Models\User;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        $users = User::withTrashed()->with(['role'])->get();
        return view('content.pages.user.user_list')->with(['users' => $users]);
    }

    public function edit($id)
    {
        return view('content.pages.user.user_edit', [
            'roles' => Role::all(),
            'user' => User::with('role')->find($id),
            "machines" => Machine::all(),
        ]);
    }

    public function editSave()
    {
        $profileHandler = new ProfileService();
        $profileHandler->saveProfile(request());
        return redirect()->back()->with([
            'alertMessage' => $profileHandler->getSavingAlertMessage(),
        ]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with([
            'alertMessage' => 'Пользователь удален',
        ]);
    }

    public function create()
    {
        return view('content.pages.user.create_user', [
            'roles' => Role::all(),
            "machines" => Machine::all(),
        ]);
    }

    public function store()
    {
        $request = request()->all();
        $checkUser = User::where('email', $request['email'])->first();
        if (empty($checkUser)) {
            try {
                $user = new User();
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->phone = GF::clearPhoneNumber($request['phone']);
                $user->password = bcrypt($request['password']);
                $user->role_id = $request['role'];
                $user->save();

                if (!empty($request['car_numbers']) && !empty($request['type_id'])) {
                    $driver = new Driver();
                    $driver->status = 7;
                    $driver->full_name = $request['name'];
                    $driver->phone = GF::clearPhoneNumber($request['phone']);
                    $driver->email = $request['email'];
                    $driver->car_numbers = $request['car_numbers'];
                    $driver->type_id = $request['type_id'];
                    $driver->user_id = $user->id;
                    $driver->save();

                    $message = "Водитель - " . $request['name'] . "\n";
                    $message .= "Почта - " . $request['email'] . "\n";
                    $message .= "Телефон - " . GF::clearPhoneNumber($request['phone']) . "\n";
                    $message .= "Пароль - " . $request['password'];

                    foreach (WhatsAppConstants::NEW_DRIVER as $phone) {
                        (new Api())->setBody($message)
                                   ->setPhone($phone)
                                   ->sendMessage();
                    }
                }

                $alertMessage = 'Пользователь добавлен';
            } catch (Exception $exception) {
                $alertMessage = 'Не удалось добавить пользователя';
            }
        } else {
            $alertMessage = 'Такой пользователь уже существует';
        }

        return redirect()->route('user.list')->with([
            'alertMessage' => $alertMessage,
        ]);
    }

    public function recover($id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect()->back()->with([
            'alertMessage' => 'Пользователь восстановлен',
        ]);
    }
}
