<?php

namespace Database\Factories;

use App\Models\Adviser;
use App\Models\Audit;
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
        return [
            'user_id' => User::count() ? User::inRandomOrder()->first()->id : User::factory(),
            'adviser_id' => Adviser::count() ? Adviser::inRandomOrder()->first()->id : Adviser::factory(),
            'qa' => [
                'notes' => 'Test notes',
                'policy_no' => '111',
                'occupation' => 'Test occupation',
                'lead_source' => 'Telemarketer',
                'with_policy' => 'yes',
                'adviser_scale' => 10,
                'is_new_client' => 'yes',
                'policy_holder' => 'Charlie Cruz',
                'received_copy' => 'yes',
                'replace_policy' => 'no',
                'confirm_adviser' => 'yes',
                'is_action_taken' => 'yes',
                'further_comments' => 'Test comments',
                'medical_agreement' => 'yes - refer to notes',
                'confirm_occupation' => 'yes',
                'medical_conditions' => 'Test medical conditions',
                'policy_understanding' => 'Test benefits',
                'bank_account_agreement' => 'yes',
                'replacement_is_discussed' => 'yes',
            ],
        ];
    }
}
