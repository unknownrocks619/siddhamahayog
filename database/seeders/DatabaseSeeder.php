<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\UserTypes::factory(5)->create();
        \App\Models\userDetail::factory(3)->create();
        \App\Models\userLogin::factory(3)->create();
        // \App\Models\Role::factory(4)->create();
    }
}
