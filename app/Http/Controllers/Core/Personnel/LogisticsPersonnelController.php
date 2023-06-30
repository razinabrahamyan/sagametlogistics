<?php

namespace App\Http\Controllers\Core\Personnel;

use App\Http\Controllers\Controller;
use App\Services\PersonalQueryLazyLoad;
use Illuminate\Http\Request;

class LogisticsPersonnelController extends Controller
{
    public function index()
    {
        return view('content.pages.personel_queries_list')->with([
            'sentQueries' => (request()->sent) ? 1 : 0,
        ]);
    }

    public function lazyLoad()
    {
        return (new PersonalQueryLazyLoad())->prepareTableParams(request())
                                            ->prepareQueries()
                                            ->initLazyLoad();
    }
}
