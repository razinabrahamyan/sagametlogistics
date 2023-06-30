<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\QueryLazyLoadService;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return (new QueryService())->index();
    }

    /**
     * @return array
     */
    public function lazyLoad()
    {
        return (new QueryLazyLoadService())->prepareTableParams(request())
                                           ->prepareQueries()
                                           ->initLazyLoad();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fileDelete(Request $request)
    {
        return (new QueryService())->fileDelete($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return (new QueryService())->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return (new QueryService())->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param $queryId
     * @return Response
     */
    public function show($queryId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $queryId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($queryId)
    {
        return (new QueryService())->edit($queryId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $queryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($queryId)
    {
        return (new QueryService())->update($queryId);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        return (new QueryService())->destroy($request);
    }

    public function recovery()
    {
        return (new QueryService())->recovery();
    }

    public function acceptQuery()
    {
        return (new QueryService())->acceptQuery(request());
    }
}
