<?php

namespace Database\Factories;

use App\Models\Adviser;
use App\Models\Client;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sa = [];

        foreach (config('services.survey.questions') as $key => $question) {
            if (in_array($question['type'], ['text', 'text-optional'])) {
                $sa[$key] = $this->faker->catchPhrase;
            } elseif ('boolean' == $question['type']) {
                $sa[$key] = 'yes';
            } elseif ('select' == $question['type']) {
                $sa[$key] = $this->faker->randomElement(collect($question['values'])->pluck('value')->all());
            }
        }

        return [
            'adviser_id' => Adviser::count() ? Adviser::inRandomOrder()->first()->id : Adviser::factory(),
            'client_id' => Client::count() ? Client::inRandomOrder()->first()->id : Client::factory(),
            'created_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'updated_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'sa' => $sa,
        ];
    }
}
