<?php

namespace App\Providers;

use App\Models\Member;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Cashier::useCustomerModel(Member::class);
        Blade::directive("google_captcha", function ($string) {
            return "<input type='hidden' name='recaptcha_token' id='recaptcha_token' class='g-captcha' />";
        });
        Paginator::useBootstrapFive();

    }
}
