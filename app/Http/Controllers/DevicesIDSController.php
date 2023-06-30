<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class DevicesIDSController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function setId(): JsonResponse
    {
        if(!Hash::check( 'apitoken7854678', \request()->header('Authorization')  ))
        {
            return response()->json(['error', 'Unauthorized'], 401);
        }
        $device = Device::query()->where('user_id', \request()->user_id)->first();
        if ($device) {
           $device->update(['device_id' => \request()->device_id]);
        } else {
            $user = User::find(\request()->user_id);
            $device = new Device();
            $device->device_id = \request()->device_id;
            $user->device()->save($device);
        }
        return response()->json($device, 200);
    }
}
