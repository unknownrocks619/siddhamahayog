<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $web_settings = [
            [
                "name" => "logo",
                "value" => "logo.jpg",
            ],
            [
                "name" => "loading_bar",
                "value" => true
            ],
            [
                "name" => "cache",
                "value" => true
            ],
            [
                "name" => "online_payment",
                "value" => true
            ],
            [
                "name" => "donation",
                "value" => true
            ],
        ];
        foreach ($web_settings as $value) {
            DB::table('web_settings')->insert($value);
        }
    }
}
