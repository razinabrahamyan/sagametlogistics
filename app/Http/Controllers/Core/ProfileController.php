<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('content.pages.profile');
    }

    public function save(Request $request)
    {
        $profileHandler = new ProfileService();
        $profileHandler->saveProfile($request);
        return redirect()->back()->with([
            'alertMessage' => $profileHandler->getSavingAlertMessage(),
        ]);
    }
}
