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
            'fsp_no' => $this->faker->randomNumber(5),
            'status' => 'Active',
        ];
    }
}
