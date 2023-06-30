<?php

use App\Http\Controllers\Core\DriversController;
use App\Http\Controllers\Core\HLRequsetController;
use App\Http\Controllers\Core\ManagerPlanController;
use App\Http\Controllers\Core\ManagersPlanCalendarController;
use App\Http\Controllers\Core\ModalController;
use App\Http\Controllers\Core\Personnel\LogisticsPersonnelController;
use App\Http\Controllers\Core\QueryController;
use App\Http\Controllers\Core\RecoveryQueryController;
use App\Http\Controllers\Core\StatisticController;

Route::group(['prefix' => 'statistics'], function () {
    Route::post('/getAll', [StatisticController::class, 'getAll'])
         ->name('axios.statistics.get');
});

Route::group(['prefix' => 'queries'], function () {
    Route::get('/recovery-query-lazy-load', [RecoveryQueryController::class, 'lazyLoad']);
    Route::post('/recover', [RecoveryQueryController::class, 'recover']);
    Route::get('/lazy-load', [QueryController::class, 'lazyLoad']);
    Route::post('/delete', [QueryController::class, 'destroy']);
    Route::post('/modal', [ModalController::class, 'queryModalContent']);
});

Route::group(['prefix' => 'drivers'], function () {
    //Местоположение всех водителей
    Route::get('/driversPoints', [DriversController::class, 'getPoints']);
    Route::post('/delete', [DriversController::class, 'destroy']);
});

Route::group(['prefix' => 'personal'], function () {
    Route::get('/queries/lazy-load', [LogisticsPersonnelController::class, 'lazyLoad']);
});

Route::group(['prefix' => 'hlr'], function () {
    Route::post('/phone/edit', [HLRequsetController::class, 'saveEdit']);
    Route::post('/phone/store', [HLRequsetController::class, 'store']);
    Route::post('/phone/destroy', [HLRequsetController::class, 'destroy']);
});

Route::group(['prefix' => 'managersPlan'], function () {
    Route::post('/saveManagerPlan', [ManagerPlanController::class, 'saveManagerPlan'])->name('axios.statistics.saveManagerPlan');
    Route::post('/getManagersData', [ManagerPlanController::class, 'getManagersData'])->name('axios.statistics.getManagersData');
    Route::post('/updateCalendarSettings', [ManagersPlanCalendarController::class, 'updateCalendarSettings'])->name('axios.statistics.updateCalendarSettings');
    Route::post('/getSettingsData', [ManagersPlanCalendarController::class, 'getSettingsData'])->name('axios.statistics.getSettingsData');
});