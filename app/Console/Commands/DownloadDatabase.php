<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DownloadDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download database to create backup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit',-1);
        ini_set('max_execution_time',-1);

        $tables = DB::select('SHOW TABLES');
        $output = '';

        foreach ($tables as $table) {
            $tableName = reset($table);

            dump( 'Taking Backup For: ' . $tableName );
            $tableData =  DB::table($tableName)->get();
            $tableCreate = DB::select("SHOW CREATE TABLE `" .  DB::getTablePrefix() . $tableName.'`');
            $output .= "-- Table structure for table $tableName \n\n";
            $output .= "{$tableCreate[0]->{'Create Table'}};\n\n";

            $output .= "-- Dumping data for table $tableName \n\n";

            foreach ($tableData as $row) {
                $output .= "INSERT INTO $tableName VALUES (";
                foreach ($row as $column) {
                    $output .= "'".addslashes($column)."', ";
                }
                $output = rtrim($output, ', ') . ");\n";
            }
            $output .= "\n\n";
        }

        $fileName = 'database_backup_' . date('Y-m-d_H-i-s') . '.sql';
        Storage::disk('local')->put('dbbackup/'.$fileName,$output);

        dump("Backup Download Complete.");

    }
}
