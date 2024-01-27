<?php

namespace App\Classes\Helpers\ExcelExport;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExcelMultipleSheet implements WithMultipleSheets
{
    use Exportable;
    protected array $sheets = [];
    protected array $sheetRecords = [];

    public function __construct(array $records = []){
        $this->sheetRecords = $records;
    }
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->sheetRecords as $title => $record) {
            $sheets[] = (new ExportFromView($record['view'],$record['params'],$title));
        }

        return $sheets;
    }

}
