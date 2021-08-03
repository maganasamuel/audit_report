<?php

namespace App\Actions\Surveys;

use App\Models\Client;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateSurvey
{
    public function update($input, Survey $survey)
    {
        Validator::make($input, [
            'completed' => ['required', 'in:0,1'],
        ], [
            'completed.required' => 'Call is not specified if draft or complete.',
            'completed.in' => 'Call is not specified if draft or complete.',
        ])->validate();

        $rules = [
            'adviser_id' => [
                'required',
                Rule::exists('advisers', 'id')->where(function ($query) {
                    return $query->where('status', 'Active');
                }),
            ],
            'is_new_client' => ['required', 'in:yes,no'],
            'client_id' => ['required_if:is_new_client,no', 'exists:clients,id'],
            'policy_holder' => ['required_if:is_new_client,yes', 'string'],
            'policy_no' => ['required_if:is_new_client,yes', 'string'],
            'client_answered' => [($input['completed'] ? 'required' : 'nullable'), 'in:0,1'],
            'call_attempts' => [($input['completed'] ? 'required_if:client_answered,0' : 'nullable'), 'array', 'min:3', 'max:3'],
            'call_attempts.*' => [($input['completed'] ? 'required_if:client_answered,0' : 'nullable'), 'date_format:d/m/Y h:i A'],
        ];

        foreach (config('services.survey.questions') as $key => $question) {
            if ('text' == $question['type']) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'string'];
            } elseif ('text-optional' == $question['type']) {
                $rules['sa.' . $key] = ['nullable', 'string'];
            } elseif ('boolean' == $question['type']) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'in:yes,no'];
            } elseif ('select' == $question['type']) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'in:' . collect($question['values'])->pluck('value')->implode(',')];
            }

            if ('adviser' == $key) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:sa.cancellation_discussed,yes' : 'nullable'), 'string'];
            }

            if ('policy_explained' == $key) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:sa.policy_replaced,yes' : 'nullable'), 'in:yes,no'];
            }

            if ('risk_explained' == $key) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:sa.policy_replaced,yes' : 'nullable'), 'in:yes,no'];
            }

            if ('benefits_discussed' == $key) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:sa.cancellation_discussed,yes' : 'nullable'), 'in:yes,no'];
            }

            if ('insurer' == $key) {
                $rules['sa.' . $key] = [($input['completed'] ? 'required_if:sa.policy_replaced,yes' : 'nullable'), 'string'];
            }
        }

        $data = Validator::make(
            $input,
            $rules,
            [
                'sa.*.required' => 'This answer is required.',
                'sa.*.required_if' => 'This answer is required.',
                'sa.*.in' => 'This answer is invalid.',
                'call_attempts.*.required_if' => 'This answer is required.',
                'call_attempts.*.date_format' => 'This answer is invalid date format.',
            ],
            [
                'adviser_id' => 'Adviser',
                'is_new_client' => 'New Client',
                'client_id' => 'Client',
                'policy_holder' => 'Policy Holder',
                'policy_no' => 'Policy Number',
                'client_answered' => 'Client Answered',
                'sa' => 'Answers',
                'sa.*' => 'Answer',
            ]
        )->validate();

        if ('yes' == $data['is_new_client']) {
            $client = Client::create(collect($data)->only([
                'policy_holder',
                'policy_no',
            ])->all());

            $data['client_id'] = $client->id;
        }

        unset($data['is_new_client'], $data['policy_holder'], $data['policy_no']);

        if ($data['client_answered']) {
            $data['call_attempts'] = null;
        } else {
            $data['sa'] = null;
        }

        $data['updated_by'] = Auth::user()->id;

        $data['completed'] = $input['completed'];

        $survey->update($data);

        return $survey;
    }
}
