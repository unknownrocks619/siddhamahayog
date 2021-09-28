<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\userDetail;
use App\Models\UserTypes;

class userDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = userDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male','female']);
        $martial_status = $this->faker->randomElement(['Married','Unmarried','Other']);
        return [
            //
            'first_name' => $this->faker->name($gender),
            'middle_name' => null,
            'last_name' => $this->faker->lastName,
            'pet_name' => $this->faker->name,
            'date_of_birth_nepali' => $this->faker->date("Y-m-d"),
            'date_of_birth_eng' => $this->faker->date('Y-m-d'),
            'gender' => ucwords($gender),
            'phone_number' => $this->faker->phoneNumber,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'user_type' => UserTypes::all()->random()->user_type,
            // 'user_category' => $this->faker->randomElement(['World Family','Dikshit','Non Dikshit']),
            'user_room_allotment' => null,
            'education_level' => $this->faker->randomElement(['Masters','Bachelor','Higher Secondary','Lower Secondary']),
            'profession' => $this->faker->randomElement(['IT','Markeeting','Designer','Driver','Sales']),
            'skills' => "Electrcity,Plumbing",
            'marritial_status'=> $martial_status,
        ];
    }
}
