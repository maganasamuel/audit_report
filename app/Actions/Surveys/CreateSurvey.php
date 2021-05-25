<?php

namespace App\Actions\Surveys;

use App\Models\Client;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateSurvey
{
    public function create($input)
    {
        $attributes = [
            'adviser_id' => 'Adviser',
            'new_client' => 'New Client',
            'policy_holder' => 'Policy Holder',
            'policy_no' => 'Policy Number',
            'client_id' => 'Client',
            'sa.answers' => 'Answers',
        ];

        foreach (range(0, 8) as $key) {
            $attributes['sa.answers.' . $key] = 'Answer';
        }

        $data = Validator::make(
            $input,
            [
                'adviser_id' => ['required', 'exists:advisers,id'],
                'new_client' => ['required', 'in:Yes,No'],
                'policy_holder' => ['required_if:new_client,Yes', 'string', 'max:255'],
                'policy_no' => ['required_if:new_client,Yes', 'max:255'],
                'client_id' => ['required_if:new_client,No', 'exists:clients,id'],
                'sa.answers' => ['required', 'array'],
                'sa.answers.0' => ['required', 'in:Yes,No'],
                'sa.answers.1' => ['required_if:sa.answers.0,Yes', 'string', 'max:255'],
                'sa.answers.2' => ['required', 'in:Yes,No'],
                'sa.answers.3' => ['required_if:sa.answers.2,Yes', 'in:Yes,No'],
                'sa.answers.4' => ['required_if:sa.answers.2,Yes', 'in:Yes,No'],
                'sa.answers.5' => ['required_if:sa.answers.0,Yes', 'in:Yes,No'],
                'sa.answers.6' => ['required', 'string', 'max:255'],
                'sa.answers.7' => ['required_if:sa.answers.2,Yes', 'string', 'max:255'],
                'sa.answers.8' => ['required', 'string', 'max:255'],
            ],
            [
                'policy_holder.required_if' => 'The Policy Holder field is required.',
                'policy_no.required_if' => 'The Policy Number field is required.',
                'client_id.required_if' => 'The Client field is required.',
                'sa.answers.*.required' => 'This answer is required.',
                'sa.answers.*.required_if' => 'This answer is required.',
            ],
            $attributes
        )->validate();

        if ('Yes' == $data['new_client']) {
            $client = Client::create(collect($data)->only([
                'policy_holder',
                'policy_no',
            ])->all());

            $data['client_id'] = $client->id;
        } else {
            $client = Client::find($data['client_id']);
        }

        unset($data['new_client'], $data['policy_holder'], $data['policy_no']);

        $data['survey_pdf'] = $client->policy_holder . ' ' . date('dmYgi') . '.pdf';
        $data['created_by'] = Auth::user()->name;

        $data['sa']['questions'] = collect(config('services.survey.questions'))->pluck('text')->all();

        $survey = Survey::create($data);

        return $survey;
    }
}
