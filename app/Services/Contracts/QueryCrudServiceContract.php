<?php

namespace App\Services\Contracts;

use App\Models\Query;
use App\Models\QueryMap;

interface QueryCrudServiceContract
{
    public function createNewQuery($request);

    public function updateQuery($request);

    public function saveQueryData(Query $query, $request): Query;

    public function addMap(Query $query, string $type): QueryMap;

    public function deleteFileByName($queryId, $filePath, string $type = 'photos'): array;
}