<?php

namespace App\Console\Commands;

use App\Classes\Programs\Imports\HanumandYagya\DharmasalaImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportUserToDharmasala extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dharmasala';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new DharmasalaImport,Storage::disk('local')->path('excel/dharmasala.xlsx'));
    }
}
