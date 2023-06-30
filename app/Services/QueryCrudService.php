<?php

namespace App\Services;

use App\Classes\Auth\AuthorizedUser;
use App\Classes\Constants\QueryMapConstants;
use App\Classes\Constants\StatusesConstants as StatusesConstants;
use App\Classes\Geolocation\Sputnik\Api as SputnikApi;
use App\Classes\Su\Webhooks\QuerySent;
use App\Models\Driver;
use App\Models\Machine;
use App\Models\Query;
use App\Models\QueryMap;
use App\Models\QuerySendedMachines;
use App\Services\Contracts\QueryCrudServiceContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QueryCrudService implements QueryCrudServiceContract
{
    private $query;

    /**
     * @param $request
     */
    public function createNewQuery($request)
    {
        $this->setQuery($this->saveQueryData((new Query()), $request));
        $this->addMap($this->getQuery(), QueryMapConstants::QUERY_MAP_CREATE);
    }

    /**
     * @param $request
     */
    public function updateQuery($request)
    {
        $this->saveQueryData($this->getQuery(), $request);
        $this->addMap($this->getQuery(), QueryMapConstants::QUERY_MAP_UPDATE);
    }

    /**
     * @param \App\Models\Query $query
     * @param $request
     * @return \App\Models\Query
     */
    public function saveQueryData(Query $query, $request): Query
    {
        $machinesDrivers = $machineTitles = $driversFullData = [];
        //Подготовка и сохранение файлов и формирование их путей
        $filesPaths = (new StorageFilesService())->setImages($request->file('metal_photos'))
                                                 ->setVideos($request->file('metal_videos'))
                                                 ->storageFiles();

        //Определяем точки адреса
        $addressPoints = (new SputnikApi())->getCoordinatesFromAddress($request["address"]);
        $addressPoints['custom_latitude'] = (!empty($request->custom_latitude) && !empty($request->custom_longitude)) ? $request->custom_latitude : null;
        $addressPoints['custom_longitude'] = (!empty($request->custom_latitude) && !empty($request->custom_longitude)) ? $request->custom_longitude : null;

        $machinesTypes = Machine::all();
        foreach ($machinesTypes as $machinesType) {
            $type = $machinesType["title_en"];

            $machinesDrivers[$type] = [
                "count" => $request->machines[$type]["count"] ?? 0,
                "drivers" => $request->machines[$type]["drivers"] ?? [],
            ];

            if ($request->machines[$type]["count"] > 0) {
                if (in_array($machinesType["title"], ['Камаз', 'МАЗ', 'МАН'])) {
                    array_unshift($machineTitles, 'Ломовоз');
                } else {
                    array_push($machineTitles, $machinesType["title"]);
                }
            }

            //Формируем массив с данными водителей
            foreach ($machinesDrivers[$type]['drivers'] as $driver) {
                $driverData = Driver::find($driver);
                if ($driverData) {
                    $driversChangedData = $request->driversData ?? [];
                    $driversFullData[] = [
                        'driver_id' => $driverData->id,
                        'driver_name' => ($driversChangedData[$driver]['name']) ?? $driverData->full_name,
                        'phone' => ($driversChangedData[$driver]['phone']) ?? $driverData->phone,
                        'car_number' => ($driversChangedData[$driver]['car_number']) ?? $driverData->car_numbers,
                        'type' => ($driversChangedData[$driver]["car_type"]) ?? $machinesType["title"],
                    ];
                }
            }
        }
        $machineTitles = array_unique($machineTitles);

        $query->client_name = $request->client_name;
        $query->departure_date = $request->departure_date;
        $query->base_departure_date = $request->base_departure_date ?? null;
        $query->phone = $request->phone;
//        $query->need_call_client = (!empty($request->need_call_client) && $request->need_call_client == "on") ? 1 : 0;
        $query->regular_client = (!empty($request->regular_client) && $request->regular_client == "on") ? 1 : 0;
        $query->address = $request->address;
        $query->address_points = $addressPoints;
        $query->machines = $machinesDrivers;
        $query->machines_title = implode(",", $machineTitles);
        if (!empty($filesPaths['images'])) {
            if (!empty($query->photos)) {
                $filesPaths['images'] = array_merge($filesPaths['images'], $query->photos);
            }
            $query->photos = $filesPaths['images'];
        }
        if (!empty($filesPaths['videos'])) {
            if (!empty($query->videos)) {
                $filesPaths['videos'] = array_merge($filesPaths['videos'], $query->videos);
            }
            $query->videos = $filesPaths['videos'];
        }
        $query->type_of_metal = $request->type_of_metal;
        $query->price = $request->price;
        $query->weight = $request->weight ?? null;
        $query->weight_from = $request->weight_from ?? null;
        $query->weight_to = $request->weight_to ?? null;
        $query->oxygen_count = $request->oxygen_count;
        $query->loaders_count = $request->loaders_count;
        $query->cutters_count = $request->cutters_count;
        $query->base_address = $request->base_address ?? 'Наша база';
        $query->is_client_need_video = 0;
        $query->comment = $request->comment;
        $query->scrap = $request->scrap ?? '';

        if (empty($query->id)) {
            $query->user_id = AuthorizedUser::getUserId();
            $query->access_token = Str::random(60);
            $query->status = StatusesConstants::NEW;
        }

        if ($query->save()) {
            //Сохраняем данные водителей
            $querySendedMachines = QuerySendedMachines::firstOrNew([
                'query_id' => $query->id,
            ]);
            $querySendedMachines->query_id = $query->id;
            $querySendedMachines->drivers_data = $driversFullData;
            $querySendedMachines->save();
        }

        //Отправка водителя в Складской Учет
        (new QuerySent())->queryDriversData($query->id);

        return $query;
    }

    /**
     * @param \App\Models\Query $query
     * @param string $type
     * @return \App\Models\QueryMap
     */
    public function addMap(Query $query, string $type): QueryMap
    {
        $queryMap = new QueryMap();
        $queryMap->data = $query->getAttributes();
        $queryMap->query_id = $query->id;
        $queryMap->status = $query->status;
        $queryMap->type = $type;
        $queryMap->user_id = AuthorizedUser::getUserId();
        $queryMap->created_at = now();
        $queryMap->updated_at = now();
        $queryMap->save();

        return $queryMap;
    }

    /**
     * @param $queryId
     * @param $filePath
     * @param string $type
     * @return array
     */
    public function deleteFileByName($queryId, $filePath, string $type = 'photos'): array
    {
        $result = [
            'success' => false,
            'alertMessage' => 'Неудалось удалить файл'
        ];
        $query = Query::find($queryId);

        if (!empty($query->{$type})) {
            $files = [];
            foreach ($query->{$type} as $file) {
                if ($file != $filePath) {
                    $files[] = $file;
                }
            }
            $query->{$type} = $files;
        }

        if ($query->save()) {
            Storage::delete($filePath);
            $result = [
                'success' => true,
                'alertMessage' => 'Файл удален'
            ];
        }

        return $result;
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        return $this->query;
    }

    public function setQuery(Query $query)
    {
        $this->query = $query;
        return $this;
    }
}