<?php


namespace App\Classes\Export;


use App\Classes\Constants\StatusesConstants;
use App\Models\Driver;
use App\Models\Query;
use Carbon\Carbon;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Table;

class ExportSendedQueriesDocx
{
    public static function daily()
    {
        $queries = Query::whereDate('departure_date', Carbon::today())->where('status', StatusesConstants::SENDED)->orderBy('id','desc')->get();
        $allDrivers = Driver::all();

        $phpWord = new PhpWord();

        $section = $phpWord->addSection(array(
            'orientation' => 'landscape',
        ));

        $section->addTextBreak(1); // перенос строки

        $table_style = new Table;
        $table_style->setBorderColor('cccccc');
        $table_style->setBorderSize(1);
        $table_style->setUnit('pct');
        $table_style->setWidth(100 * 50);

        $styleTable = array('borderSize' => 6, 'borderColor' => '999999', 'width' => 100);

        $cellHCentered = array('align' => 'center','valign' => 'center');
        $cellVCentered = array('valign' => 'center');

        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $table = $section->addTable($table_style);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(2000, $cellVCentered)->addText('Техника', array('bold' => true), $cellHCentered);
        $table->addCell(2000, $cellVCentered)->addText('Время', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Резчики', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Грузчики', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Баллоны', array('bold' => true), $cellHCentered);
        $table->addCell(6000, $cellVCentered)->addText('Комментарии', array('bold' => true), $cellHCentered);


        foreach ($queries as $query) {
            $queryMachinesDrivers = [];
            foreach ($query->machines as $machine) {
                foreach ($machine->drivers as $driver) {
                    $car =  $allDrivers->where('id', $driver)->first();
                    $queryMachinesDrivers[$car->id] = $car->car_numbers;
                }
            }

            $table->addRow();
            $table->addCell(2000, $cellVCentered)->addText(implode(',', $queryMachinesDrivers), null, $cellHCentered);
            $table->addCell(2000, $cellVCentered)->addText((!empty($query->base_departure_date)) ? date('d-m H:i', strtotime($query->base_departure_date)) : 'Не указано', null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->cutters_count, null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->loaders_count, null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->oxygen_count, null, $cellHCentered);
            $table->addCell(6000, $cellVCentered)->addText(str_repeat(' ', 260), null, $cellHCentered);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        header("Content-Type:text/plain");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment;filename="file.docx"');
        $objWriter->save('php://output');
    }

    public static function tomorrow()
    {
        $queries = Query::whereDate('departure_date', Carbon::tomorrow())->where('status', StatusesConstants::SENDED)->orderBy('id','desc')->get();
        $allDrivers = Driver::all();

        $phpWord = new PhpWord();

        $section = $phpWord->addSection(array(
            'orientation' => 'landscape',
        ));

        $section->addTextBreak(1); // перенос строки

        $table_style = new Table;
        $table_style->setBorderColor('cccccc');
        $table_style->setBorderSize(1);
        $table_style->setUnit('pct');
        $table_style->setWidth(100 * 50);

        $styleTable = array('borderSize' => 6, 'borderColor' => '999999', 'width' => 100);

        $cellHCentered = array('align' => 'center','valign' => 'center');
        $cellVCentered = array('valign' => 'center');

        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $table = $section->addTable($table_style);
        $table->addRow(null, array('tblHeader' => true));
        $table->addCell(2000, $cellVCentered)->addText('Техника', array('bold' => true), $cellHCentered);
        $table->addCell(2000, $cellVCentered)->addText('Время', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Резчики', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Грузчики', array('bold' => true), $cellHCentered);
        $table->addCell(1200, $cellVCentered)->addText('Баллоны', array('bold' => true), $cellHCentered);
        $table->addCell(6000, $cellVCentered)->addText('Комментарии', array('bold' => true), $cellHCentered);


        foreach ($queries as $query) {
            $queryMachinesDrivers = [];
            foreach ($query->machines as $machine) {
                foreach ($machine->drivers as $driver) {
                    $car =  $allDrivers->where('id', $driver)->first();
                    $queryMachinesDrivers[$car->id] = $car->car_numbers;
                }
            }

            $table->addRow();
            $table->addCell(2000, $cellVCentered)->addText(implode(',', $queryMachinesDrivers), null, $cellHCentered);
            $table->addCell(2000, $cellVCentered)->addText((!empty($query->base_departure_date)) ? date('d-m H:i', strtotime($query->base_departure_date)) : 'Не указано', null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->cutters_count, null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->loaders_count, null, $cellHCentered);
            $table->addCell(1200, $cellVCentered)->addText($query->oxygen_count, null, $cellHCentered);
            $table->addCell(6000, $cellVCentered)->addText(str_repeat(' ', 260), null, $cellHCentered);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        header("Content-Type:text/plain");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment;filename="file.docx"');
        $objWriter->save('php://output');
    }

}