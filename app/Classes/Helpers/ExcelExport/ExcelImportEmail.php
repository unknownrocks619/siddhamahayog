<?php

namespace App\Classes\Helpers\ExcelExport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportEmail implements ToCollection, WithStartRow, WithHeadingRow {

    protected array $emailList = [];

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow() {
        return 1;
    }

    public function collection(Collection $collection) {
        
        foreach ($collection as $email) {

            if ( in_array($email->first(), $this->emailList) ) {
                continue;
            }

            $this->emailList[] = $email->first();
        }
    }

    public function all(): array {
        return $this->emailList;
    }

  
}