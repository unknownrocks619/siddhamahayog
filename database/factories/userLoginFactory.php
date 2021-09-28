<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\userDetail;
use App\Models\userLogin;
use Illuminate\Support\Facades\Hash;

class userLoginFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = userLogin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_detail_id' => userDetail::all()->random()->id,
            'user_type' => "admin",
            'email' => $this->faker->unique()->safeEmail,
            'verified' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'verification_link' => null,
            'account_status' => $this->faker->randomElement(['Active','Unverified','Hold']),
            'created_by_user' => null,
        ];
    }
}
