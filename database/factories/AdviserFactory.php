<?php

namespace Database\Factories;

use App\Models\Adviser;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdviserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Adviser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'fsp_no' => $this->faker->randomNumber(5),
            'contact_number' => $this->faker->numerify('###########'),
            'address' => $this->faker->address,
            'fap_name' => $this->faker->name,
            'fap_email' => $this->faker->safeEmail,
            'fap_fsp_no' => $this->faker->randomNumber(5),
            'fap_contact_number' => $this->faker->numerify('###########'),
            'status' => $this->faker->randomElement(['Active', 'Terminated']),
        ];
    }
}
