<?php

namespace App\Services;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\QueryMapConstants;
use App\Models\Query;
use App\Services\Contracts\QueryStatusServiceContract;
use Exception;
use Illuminate\Http\Request;

class QueryStatusService implements QueryStatusServiceContract
{
    private $queryStatusAlertMessage;

    public function update($request)
    {
        $statusHandler = new QueryStatusService();
        $statusHandler->updateQueryStatus($request);
        return response()->json([
            'alertMessage' => $statusHandler->getQueryStatusAlertMessage(),
        ]);
    }

    public function updateQueryStatus($request)
    {
        try {
            $query = Query::find($request->queryId);
            $query->status = $request->statusId;
            if ($query->save()) {
                (new QueryCrudService())->addMap($query, QueryMapConstants::QUERY_MAP_UPDATE);
                $this->setQueryStatusAlertMessage(AlertMessages::STATUS_CHANGE_SUCCESS);
            } else {
                $this->setQueryStatusAlertMessage(AlertMessages::STATUS_CHANGE_FAILED);
            }
        } catch (Exception $e) {
            $this->setQueryStatusAlertMessage($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getQueryStatusAlertMessage()
    {
        return $this->queryStatusAlertMessage;
    }

    /**
     * @param mixed $queryStatusAlertMessage
     * @return QueryStatusService
     */
    public function setQueryStatusAlertMessage($queryStatusAlertMessage)
    {
        $this->queryStatusAlertMessage = $queryStatusAlertMessage;
        return $this;
    }
}