<?php

namespace App\Classes\Helpers\ExcelExport;

use Maatwebsite\Excel\Facades\Excel;

class ExcelExportDownload
{
    public function export($excelExportController,$filename=null) {
        return (new Excel())::download($excelExportController,$filename ?? 'download-list.xlsx');
    }
}
