<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\RecoveryQueryLazyLoadService;
use function request;

class RecoveryQueryController extends Controller
{
    public function lazyLoad()
    {
        return (new RecoveryQueryLazyLoadService())->prepareTableParams(request())
                                                   ->prepareQueries()
                                                   ->initLazyLoad();
    }

    public function recover(){
        return (new RecoveryQueryLazyLoadService())->recover(request());
    }
}
