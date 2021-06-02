<?php

namespace App\Actions\Surveys;

use App\Models\Client;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateSurvey
{
    public function create($input)
    {
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
        ];

        foreach (config('services.survey.questions') as $key => $question) {
            if ('text' == $question['type']) {
                $rules['sa.' . $key] = ['required', 'string'];
            } elseif ('text-optional' == $question['type']) {
                $rules['sa.' . $key] = ['nullable', 'string'];
            } elseif ('boolean' == $question['type']) {
                $rules['sa.' . $key] = ['required', 'in:yes,no'];
            } elseif ('select' == $question['type']) {
                $rules['sa.' . $key] = ['required', 'in:' . collect($question['values'])->pluck('value')->implode(',')];
            }

            if ('adviser' == $key) {
                $rules['sa.' . $key] = ['required_if:sa.cancellation_discussed,yes', 'string'];
            }

            if ('policy_explained' == $key) {
                $rules['sa.' . $key] = ['required_if:sa.policy_replaced,yes', 'in:yes,no'];
            }

            if ('risk_explained' == $key) {
                $rules['sa.' . $key] = ['required_if:sa.policy_replaced,yes', 'in:yes,no'];
            }

            if ('benefits_discussed' == $key) {
                $rules['sa.' . $key] = ['required_if:sa.cancellation_discussed,yes', 'in:yes,no'];
            }

            if ('insurer' == $key) {
                $rules['sa.' . $key] = ['required_if:sa.policy_replaced,yes', 'string'];
            }
        }

        $data = Validator::make(
            $input,
            $rules,
            [
                'sa.*.required' => 'This answer is required.',
                'sa.*.required_if' => 'This answer is required.',
                'sa.*.in' => 'This answer is invalid.',
            ],
            [
                'adviser_id' => 'Adviser',
                'is_new_client' => 'New Client',
                'client_id' => 'Client',
                'policy_holder' => 'Policy Holder',
                'policy_no' => 'Policy Number',
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

        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        $survey = Survey::create($data);

        return $survey;
    }
}
