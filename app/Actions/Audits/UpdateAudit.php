<?php

namespace App\Actions\Audits;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateAudit
{
    public function update($input, Audit $audit)
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

        foreach (config('services.audit.questions') as $key => $question) {
            if ('text' == $question['type']) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'string'];
            } elseif ('text-optional' == $question['type']) {
                $rules['qa.' . $key] = ['nullable', 'string'];
            } elseif ('boolean' == $question['type']) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'in:yes,no'];
            } elseif ('select' == $question['type']) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:client_answered,1' : 'nullable'), 'in:' . collect($question['values'])->pluck('value')->implode(',')];
            }

            if ('medical_conditions' == $key) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:qa.medical_agreement,yes,not sure' : 'nullable')];
            }

            if ('replacement_is_discussed' == $key) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:qa.replace_policy,yes' : 'nullable')];
            }

            if ('occupation' == $key) {
                $rules['qa.' . $key] = [($input['completed'] ? 'required_if:qa.confirm_occupation,no' : 'nullable')];
            }
        }

        $data = Validator::make(
            $input,
            $rules,
            [
                'qa.*.required' => 'This answer is required.',
                'qa.*.required_if' => 'This answer is required.',
                'qa.*.in' => 'This answer is invalid.',
                'call_attempts.*.required_if' => 'This answer is required.',
                'call_attempts.*.date_format' => 'This answer is invalid date format.',
            ],
            [
                'adviser_id' => 'Adviser',
                'is_new_client' => 'New Client',
                'client_id' => 'Client',
                'policy_holder' => 'Policy Holder',
                'policy_no' => 'Policy Number',
                'lead_source' => 'Lead Source',
                'client_answered' => 'Client Answered',
                'qa' => 'Answers',
                'aq.*' => 'Answer',
            ]
        )->validate();

        if ('yes' == $data['is_new_client']) {
            $client = Client::create(collect($data)->only(['policy_holder', 'policy_no'])->all());
            $data['client_id'] = $client->id;
        }

        unset($data['is_new_client'], $data['policy_holder'], $data['policy_no']);

        if ($data['client_answered']) {
            $data['call_attempts'] = null;
        } else {
            $data['qa'] = null;
        }

        $data['updated_by'] = Auth::user()->id;

        $data['completed'] = $input['completed'];

        $audit->update($data);

        return $audit;
    }
}
