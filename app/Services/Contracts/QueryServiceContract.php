<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface QueryServiceContract
{
    public function index();

    public function fileDelete(Request $request);

    public function create();

    public function store(Request $request);

    public function show($queryId);

    public function edit($queryId);

    public function update($queryId);

    public function destroy(Request $request);

    public function recovery();
}