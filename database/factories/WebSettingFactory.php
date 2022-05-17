<?php

namespace Database\Factories;

use App\Models\WebSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebSetting>
 */
class WebSettingFactory extends Factory
{

    protected $model = WebSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
            ]
        ];
    }
}
