<?php

namespace App\Classes\Export\Inventory;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InventoryExcel implements FromArray, WithDrawings
{
    protected $data;

    /**
     * ExcelArray constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download($this, 'invoices.xlsx');
    }

    public function drawings()
    {
        $alphas = range('A', 'Z');
        foreach ($this->data as $rowKey => $row) {
            foreach ($row as $itemKey => $item) {
                if (str_contains($item, 'http')) {
                    $image = QrCode::format('png')
                                   ->size(100)->errorCorrection('H')
                                   ->generate($item . $itemKey);

                    $fileName = time() . rand(0, 100000) . '.png';
                    Storage::disk('public')->put('public/qr/' . $fileName, $image);

                    $drawing[$rowKey] = new Drawing();
                    $drawing[$rowKey]->setName('QR');
                    $drawing[$rowKey]->setDescription('QR код');
                    $drawing[$rowKey]->setPath(public_path('storage/public/qr/' . $fileName));
                    $drawing[$rowKey]->setHeight(90);
                    $drawing[$rowKey]->setCoordinates($alphas[$itemKey] . ($rowKey + 1));

                    unset($this->data[$rowKey][$itemKey]);
                }
            }
        }

        return $drawing;
    }
}