<?php

namespace App\Http\Controllers;

use App\Classes\Export\ExportSendedQueriesDocx;

class ExportController extends Controller
{

    public function exportTodaySentQueriesExcel()
    {
        ExportSendedQueriesDocx::daily();
    }

    public function exportTomorrowSentQueriesExcel()
    {
        ExportSendedQueriesDocx::tomorrow();
    }
}
