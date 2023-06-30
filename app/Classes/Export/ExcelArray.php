<?php

namespace App\Classes\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelArray implements FromArray
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
    public function array() : array
    {
        return $this->data;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export() : BinaryFileResponse
    {
        return Excel::download($this, 'invoices.xlsx');
    }
}