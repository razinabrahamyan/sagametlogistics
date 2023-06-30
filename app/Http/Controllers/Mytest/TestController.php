<?php

namespace App\Http\Controllers\Mytest;

use App\Classes\ChatApi\Api;
use App\Classes\Constants\StatusesConstants;
use App\Classes\ControllersHandlers\Cron\CronHandler;
use App\Classes\Convertors\ConvertFile;
use App\Classes\Convertors\Drivers\InterventionImageDriver;
use App\Classes\Export\ExcelArray;
use App\Classes\Export\Inventory\InventoryExcel;
use App\Classes\Export\InvoicesExport;
use App\Classes\FortMonitor\FortMonitorHelpers;
use App\Classes\Pusher\Triggers\FrontTriggers;
use App\Classes\SmsCApi\SmsCApi;
use App\Classes\Su\Webhooks\QuerySent;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Machine;
use App\Models\Query;
use App\Services\QueryCrudService;
use BaconQrCode\Encoder\QrCode;
use Goutte\Client;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Decomposition\QR;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class TestController extends Controller
{
    public function weightParse()
    {
        $queries = Query::all();

//        $r = '0,3';
//        $explodes = explode('-', $r);
//        $number = preg_replace("/[^,.0-9]/", '', $explodes[0]);
//        $number = preg_replace("/,/", '.', $number);


        foreach ($queries as $key => $query) {
            $explodes = explode('-', $query->weight);
            foreach ($explodes as $cc => $explode) {
                $number = preg_replace("/[^,.0-9]/", '', $explode);
                $number = preg_replace("/,/", '.', $number);

                if (is_numeric($number)) {
                    if ($cc == 0) {
                        $query->update([
                            'weight_from' => $number ?? 0,
                        ]);
                    } elseif ($cc == 1) {
                        $query->update([
                            'weight_to' => $number ?? null,
                        ]);
                    }
                }
            }
        }
    }

//    public function export()
//    {
//        $export = [
//            [1, 2, 'https://jobtools.ru'],
//            [1, 2, 'https://jobtools.ru'],
//            [1, 2, 'https://jobtools.ru'],
//            [1, 2, 'https://jobtools.ru'],
//        ];
//
//        return (new InventoryExcel($export))->export();
//    }
//
//    public function regexp()
//    {
//        $regexp = '/<td class="column10 .*>(.*?)(,.*)?<\/td>/';
//
//        $filepath = 'LEAD_20220216_8e04a606_620d273c96cfa.html';
//        $content = file_get_contents($filepath);
//
//        preg_match_all($regexp, $content, $matches);
//        $array = [];
//        foreach ($matches[1] as $match) {
//            $clear = preg_replace("/[^0-9]/", '', $match);
//            if (!empty($clear)) {
//                $gorod = substr($clear, 1, 3);
//                if ($gorod != 495 && strlen($clear)==11) {
//                    $array[] = $clear;
//                }
//            }
//        }
//        dump(count($array));
//        file_put_contents('номера.txt', implode("\n", array_unique($array)));
//    }

//    public function archivateImages()
//    {
//        set_time_limit(0);
//
//        $date = '31.12.2021';
//        $path = 'storage/files/query/images/';
//
//        $files = glob($path . '*.{webp}', GLOB_BRACE);
//        foreach ($files as $key => $file) {
//            if (file_exists($file)) {
//                if (filemtime($file) < strtotime($date)) {
//                    unlink(public_path() . '/' . $file);
//                }
//            }
//        }
//    }
//
//    public function archivateVideos()
//    {
//        set_time_limit(0);
//
//        $date = '31.12.2021';
//        $path = 'storage/files/query/videos/';
//
//        $files = glob($path . '*.{mp4}', GLOB_BRACE);
//        foreach ($files as $key => $file) {
//            if (file_exists($file)) {
//                if (filemtime($file) < strtotime($date)) {
//                    unlink(public_path() . '/' . $file);
//                }
//            }
//        }
//    }

//    public function smsc()
//    {
////        dd(strpos("OK - 1 SMS, ID - 7",'OK') !== false);
//        (new SmsCApi())->sendHLR([
//            [
//                'phone' => '89254310462'
//            ]
//        ]);
//    }
//
//    public function webhook()
//    {
//        foreach (Query::where('status', 2)->get() as $query) {
//            (new QuerySent())->queryDriversData($query->id);
//        }
//    }
//
//    public function docx()
//    {
//        $queries = Query::whereDate('departure_date', \Carbon\Carbon::today())->where('status', StatusesConstants::SENDED)->get();
//        $allDrivers = Driver::all();
//
//
//        $phpWord = new PhpWord();
//
//        $section = $phpWord->addSection(array(
//            'orientation' => 'landscape',
//        ));
//
//        $section->addTextBreak(1); // перенос строки
//
//        $table_style = new Table;
//        $table_style->setBorderColor('cccccc');
//        $table_style->setBorderSize(1);
//        $table_style->setUnit('pct');
//        $table_style->setWidth(100 * 50);
//
//        $styleTable = array('borderSize' => 6, 'borderColor' => '999999', 'width' => 100);
//        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
//        $cellRowContinue = array('vMerge' => 'continue');
//        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
//        $cellColSpan3 = array('gridSpan' => 3, 'valign' => 'center');
//
//        $cellHCentered = array('align' => 'center');
//        $cellVCentered = array('valign' => 'center');
//
//        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
//        $table = $section->addTable($table_style);
//        $table->addRow(null, array('tblHeader' => true));
//        $table->addCell(2000, $cellVCentered)->addText('Техника', array('bold' => true), $cellHCentered);
//        $table->addCell(2000, $cellVCentered)->addText('Время', array('bold' => true), $cellHCentered);
//        $table->addCell(1200, $cellVCentered)->addText('Резчики', array('bold' => true), $cellHCentered);
//        $table->addCell(1200, $cellVCentered)->addText('Грузчики', array('bold' => true), $cellHCentered);
//        $table->addCell(1200, $cellVCentered)->addText('Баллоны', array('bold' => true), $cellHCentered);
//        $table->addCell(6000, $cellVCentered)->addText('Комментарии', array('bold' => true), $cellHCentered);
//
//
//        $queryMachinesDrivers = [];
//        foreach ($queries as $query) {
//            foreach ($query->machines as $machine) {
//                foreach ($machine->drivers as $driver) {
//                    $queryMachinesDrivers[] = $allDrivers->where('id', $driver)->first()->car_numbers;
//                }
//            }
//
//            $table->addRow();
//            $table->addCell(2000, $cellVCentered)->addText(implode(',', array_unique($queryMachinesDrivers)), null, $cellHCentered);
//            $table->addCell(2000, $cellVCentered)->addText($query->departure_date, null, $cellHCentered);
//            $table->addCell(1200, $cellVCentered)->addText($query->cutters_count, null, $cellHCentered);
//            $table->addCell(1200, $cellVCentered)->addText($query->loaders_count, null, $cellHCentered);
//            $table->addCell(1200, $cellVCentered)->addText($query->oxygen_count, null, $cellHCentered);
//            $table->addCell(6000, $cellVCentered)->addText(str_repeat(' ', 260), null, $cellHCentered);
//
//            $export[] = [
//                implode(',', $queryMachinesDrivers),
//                $query->departure_date,
//                $query->cutters_count,
//                $query->loaders_count,
//                $query->oxygen_count,
//                $query->address,
//            ];
//        }
//
//        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
//        header("Content-Type:text/plain");
//        header("Content-Type: application/download");
//        header('Content-Disposition: attachment;filename="file.docx"');
//        $objWriter->save('php://output');
//    }
//
//    public function string()
//    {
//        $array = ["Логист", "Тестовый"];
//        dd(mb_substr($array[0], 0, 1));
//    }

//    public function export()
//    {
//        $queryMachinesDrivers = [];
//        $export = [
//            ["Техника", "Время выезда", "Резчики", "Грузчики", "Баллоны", "Адрес", "Комментарии"]
//        ];
//        $queries = Query::whereDate('departure_date', \Carbon\Carbon::today())->where('status', StatusesConstants::SENDED)->get();
//        $allDrivers = Driver::all();
//
//        foreach ($queries as $query) {
//            foreach ($query->machines as $machine) {
//                foreach ($machine->drivers as $driver) {
//                    $queryMachinesDrivers[] = $allDrivers->where('id', $driver)->first()->car_numbers;
//                }
//            }
//
//            $export[] = [
//                implode(',', $queryMachinesDrivers),
//                $query->departure_date,
//                $query->cutters_count,
//                $query->loaders_count,
//                $query->oxygen_count,
//                $query->address,
//                $query->comment,
//            ];
//        }
//
//        return (new ExcelArray($export))->export();
//    }

//    public function queryTest()
//    {
////        $query = Query::find(32);//32
////        $query->status= StatusesConstants::SENDED;
////        $query->save();
//    }
//
//    public function sputnik()
//    {
//        dd((new \App\Classes\Geolocation\Sputnik\Api())->getCoordinatesFromAddress('Москва, Тверская улица 13'));
//    }
//
//    public function chatApi()
//    {
////        $wa = (new Api())->setBody("https://ru.wikipedia.org/")
////                         ->setDescription('Сагамет Логистикс упрощает коммуникацию внутри компании')
////                         ->setText("Для обработки заявки перейдите по ссылке \n https://ru.wikipedia.org/")
////                         ->setPhone('79169672786')
////                         ->sendLink();
//        $wa = (new Api())->status();
//        dd($wa);
//    }
//
//    public function chart()
//    {
//        $queriesByManagers = Query::with('manager')
//                                  ->where('created_at', '>=', Carbon::now()->subDays(365)->toDateTimeString())
//                                  ->whereIn('status', [StatusesConstants::PROCESSED, StatusesConstants::CANCELED])
//                                  ->get()
//                                  ->groupBy('user_id');
//
//        $chart = (new MainChartQueryBuilder())->setData($queriesByManagers)
//                                              ->prepareChartData();
//
//        dd($chart);
//    }
//
//    public function fortMonitor()
//    {
//        dd(FortMonitorHelpers::getCarsInfo());
//    }
//
//    public function getNewDriversFromFortMonitor()
//    {
//        dd(CronHandler::checkNewDriversFromFortMonitor());
//    }
//
//    public function lazyLoad()
//    {
//
//    }
//
//    public function convertors()
//    {
//        $driver = new InterventionImageDriver();
//        $convert = new ConvertFile($driver);
//        $convert->setFile();
//        dump($convert->convertFile());
//    }
//
//    public function email()
//    {
//        $query = new QueryCrudService();
//        $query->deleteFileByName(3, 'images/query/photos/1fb770a146c40d24f199bc7c05c3fe1f.webp', 'photo');
//    }
//
//    public function pusher()
//    {
//        FrontTriggers::newQueryNotify();
//    }
//
//    public function create()
//    {
//        Query::create([
//            "status" => 1,
//            "client_name" => "Артур 1",
//            "departure_date" => date('Y-m-d H:i:s', strtotime(now()) + rand(0, 3600 * 24 * 3)),
//            "phone" => "79169672786",
//            "need_call_client" => "1",
//            "regular_client" => "1",
//            "address" => "Dominican Republic",
//            "address_points" => '{"longitude":37.754272,"latitude":55.444794}',
//            "photos" => null,
//            "videos" => null,
//            "type_of_metal" => "1",
//            "price" => rand(20000, 24000),
//            "weight" => rand(1000, 3000),
//            "oxygen_count" => rand(0, 3),
//            "loaders_count" => rand(0, 3),
//            "cutters_count" => rand(0, 3),
//            "machines" => '{"valdai":{"count":"1","drivers":["31"]},"kamaz":{"count":"0","drivers":[]},"maz":{"count":"0","drivers":[]},"man":{"count":"0","drivers":[]}}',
//            "base_address" => "Наша база",
//            "is_client_need_video" => "0",
//            "comment" => "Коммент 1",
//            "user_id" => rand(4, 6),
//            "created_at" => now(),
//            'updated_at' => now(),
//            "access_token" => \Illuminate\Support\Str::random(60),
//        ]);
//    }
}
