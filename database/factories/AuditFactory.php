<?php

namespace Database\Factories;

use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Audit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qa = [];

        foreach (config('services.audit.questions') as $key => $question) {
            if (in_array($question['type'], ['text', 'text-optional'])) {
                $qa[$key] = $this->faker->catchPhrase;
            } elseif ('boolean' == $question['type']) {
                $qa[$key] = $this->faker->randomElement(['yes', 'no']);
            } elseif ('select' == $question['type']) {
                $qa[$key] = $this->faker->randomElement(collect($question['values'])->pluck('value')->all());
            }
        }

        return [
            'adviser_id' => Adviser::count() ? Adviser::inRandomOrder()->first()->id : Adviser::factory(),
            'client_id' => Client::count() ? Client::inRandomOrder()->first()->id : Client::factory(),
            'created_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'updated_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'lead_source' => $this->faker->randomElement(['Telemarketer', 'BDM', 'Self-Generated']),
            'qa' => $qa,
            'client_answered' => 1
        ];
    }
}
