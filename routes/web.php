<?php

use App\Http\Controllers\Core\AddressesMapController;
use App\Http\Controllers\Core\DriversController;
use App\Http\Controllers\Core\HLRequsetController;
use App\Http\Controllers\Core\ManagerPlanController;
use App\Http\Controllers\Core\Personnel\LogisticsPersonnelController;
use App\Http\Controllers\Core\ModalController;
use App\Http\Controllers\Core\LogisticPersonnel;
use App\Http\Controllers\Core\PrivacyPolicyController;
use App\Http\Controllers\Core\ProfileController;
use App\Http\Controllers\Core\QueryController;
use App\Http\Controllers\Core\StatisticController;
use App\Http\Controllers\Core\StatusController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Роутинг для авторизованных пользователей CRM*/
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [QueryController::class, 'index'])->name('home'); //Домашняя страница

    //Отображение обработчика заявки
    Route::group(['middleware' => ['queryEdit']], function () {
        Route::group(['prefix' => 'queries'], function () {
            Route::get('/handle/{id}', [QueryController::class, 'edit'])->name('showQuery');
        });
    });

    Route::group(['middleware' => ['manager']], function () {
        Route::post('/get-status', [StatisticController::class, 'getStatus'])->name('getStatus');

        //Список всех заявок
        Route::get('/query-recovery', [QueryController::class, 'recovery'])->name('query.recovery'); //Домашняя страница

        //Отправка превью заявки по ватсапу
        Route::post('/query/send-wa', [LogisticPersonnel::class, 'sendToWhatsApp']);
        Route::post('/query/accept-query', [QueryController::class, 'acceptQuery']);

        //Создание новой заявки
        Route::group(['prefix' => 'new-query'], function () {
            Route::get('/', [QueryController::class, 'create'])->name('newQuery');
            Route::post('/store', [QueryController::class, 'store'])->name('storeQuery');
        });

        //Создание нового выезда машины с весами
        Route::group(['prefix' => 'departure'], function () {
            Route::get('/new-departure', [QueryController::class, 'create'])->name('newDeparture');
            Route::post('/store', [QueryController::class, 'store'])->name('storeDeparture');
        });


        Route::group(['prefix' => 'export', 'middleware' => ['logistician']], function () {
            Route::get('/exportTodaySentQueriesExcel', [ExportController::class, 'exportTodaySentQueriesExcel'])
                 ->name('exportTodaySentQueriesExcel');

            Route::get('/exportTomorrowSentQueriesExcel', [ExportController::class, 'exportTomorrowSentQueriesExcel'])
                 ->name('exportTomorrowSentQueriesExcel');
        });

        Route::group(['prefix' => 'queries'], function () {
            //Обновление заявки
            Route::put('/update/{id}', [QueryController::class, 'update'])->name('updateQuery');
            //Обновление статуса заявку
            Route::post('/status/update', [StatusController::class, 'update'])->name('updateQueryStatus');
            //Удаление файлов заявки
            Route::post('/file/delete', [QueryController::class, 'fileDelete'])->name('deleteQueryFile');
            //Подгрузка контента модального окна истории заявки
            Route::post('/map/content', [ModalController::class, 'queryMapModalContent'])->name('queryMapModal');
            //Подгрузка контента модального окна заявки
//            Route::post('/modal', [ModalController::class, 'queryModalContent'])->name('queryModal');
        });

        Route::group(['prefix' => 'monitoring', 'middleware' => ['logistician']], function () {
            //Список водителей
            Route::get('/drivers', [DriversController::class, 'index'])->name('drivers');
            Route::get('/drivers/create', [DriversController::class, 'create'])->name('drivers.create');
            Route::post('/drivers/store', [DriversController::class, 'store'])->name('drivers.store');
            Route::get('/drivers/edit/{id}', [DriversController::class, 'edit'])->name('driverEdit');
            Route::post('/drivers/update', [DriversController::class, 'update'])->name('driverUpdate');

            //Статистика
            Route::post('/statistics/getLinearStatistic', [StatisticController::class, 'getLinearStatistic'])
                 ->name('getLinearStatistic');
        });

        //Статистика
        Route::group(['prefix' => 'monitoring', 'middleware' => ['statisticsAccess']], function () {
            Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');
            Route::get('/managersPlan', [ManagerPlanController::class, 'index'])->name('statistics.managersPlan');
        });

        //Карта адресов
        Route::group(['prefix' => 'addresses', 'middleware' => ['logistician']], function () {
            Route::get('/map', [AddressesMapController::class, 'index'])->name('addresses.map');
            Route::post('/map/filter', [AddressesMapController::class, 'filterAddressesMaps'])->name('addresses.map.filterAddressesMaps');
            Route::post('/map/sendAddressToWA', [AddressesMapController::class, 'sendAddressToWA'])->name('addresses.map.sendAddressToWA');
        });
    });

    //Профиль
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::post('/save', [ProfileController::class, 'save'])->name('profile.save');
    });

    //Админ
    Route::group(['middleware' => ['adminAccess']], function () {
        Route::group(['prefix' => 'telephony'], function () {
            Route::get('/hlr', [HLRequsetController::class, 'index'])->name('hlr.list');
            Route::post('/sendhlr', [HLRequsetController::class, 'checkPhonesHLR'])->name('hlr.sendhlr');
            Route::get('/hlr/edit-list', [HLRequsetController::class, 'edit'])->name('hlr.edit.list');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/list', [UserController::class, 'list'])->name('user.list');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('/edit/save', [UserController::class, 'editSave'])->name('user.edit.save');
            Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
            Route::get('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store');
            Route::get('/recover/{id}', [UserController::class, 'recover'])->name('user.recover');
        });
    });

    /* Роутинг для персонала логистики*/
    Route::group(['middleware' => ['logisticsPersonnel']], function () {
        //
    });
    /* Роутинг для авторизованных пользователей */

    /*Роут для тестов*/
    Route::get('/mytest/{action}', function ($action, Request $request) {
        $class = "App\\Http\\Controllers\\Mytest\\TestController";
        if (class_exists($class) && method_exists($class, $action)) {
            return (new $class())->callAction($action, [$request]);
        } else
            return response('Экшена ' . $action . ' не существует');

        return redirect()->route('lk');
    });
    /*Роут для тестов*/
});
/* Роутинг для авторизованных пользователей */

Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.policy');

/* Роутинг для отображения заявки в отдельном окне */
Route::get('query/preview/{id}/{token}', [LogisticPersonnel::class, 'showQuery'])->name('previewQuery');
/* Роутинг для отображения заявки в отдельном окне */

/* Базовый роутинг авторизации */
Auth::routes(['verify' => true]);
/* Базовый роутинг авторизации */

/* Роутинг для авторизации */
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthenticationController::class, 'login'])->name('authLogin');
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('authLogout');
});
/* Роутинг для авторизации */