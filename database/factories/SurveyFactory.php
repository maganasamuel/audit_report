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
        return [
            'adviser_id' => Adviser::count() ? Adviser::inRandomOrder()->first()->id : Adviser::factory(),
            'client_id' => Client::count() ? Client::inRandomOrder()->first()->id : Client::factory(),
            'sa' => [
                'answers' => [
                    'Yes',
                    'Alice',
                    'Yes',
                    'Yes',
                    'Yes',
                    'Yes',
                    'Test cancel',
                    'Igor India',
                    'Test improve',
                ],
                'questions' => [
                    'Have you had a chance to discuss this cancellation with your Adviser?',
                    'Who is your Adviser?',
                    'Are you replacing your Partners Life Policy with one at another Provider?',
                    'Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?',
                    'Did your Adviser explain the risk of Non-Disclosure or Misstatement to you?',
                    'Did your Adviser discuss both the benefits you forfeit and any risks you might be exposed to in cancelling your cover from us?',
                    'Why are you cancelling your Policy with us?',
                    'Who is your new insurer?',
                    'What could we do to improve?',
                ],
            ],
            'created_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'updated_by' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'survey_pdf' => '',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Survey $survey) {
            $survey->update([
                'survey_pdf' => $survey->client->policy_holder . ' ' . date('dmYgi') . '.pdf',
            ]);
        });
    }
}
