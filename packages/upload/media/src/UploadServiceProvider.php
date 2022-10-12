<?php

namespace Upload\Media;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations/");
    }

    public function register()
    {
    }
}
