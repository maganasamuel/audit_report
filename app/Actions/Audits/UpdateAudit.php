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
            'lead_source' => ['required', 'in:' . implode(',', config('services.lead_source'))],
        ];

        foreach (config('services.audit.questions') as $key => $question) {
            if ('text' == $question['type']) {
                $rules['qa.' . $key] = ['required', 'string'];
            } elseif ('text-optional' == $question['type']) {
                $rules['qa.' . $key] = ['nullable', 'string'];
            } elseif ('boolean' == $question['type']) {
                $rules['qa.' . $key] = ['required', 'in:yes,no'];
            } elseif ('select' == $question['type']) {
                $rules['qa.' . $key] = ['required', 'in:' . collect($question['values'])->pluck('value')->implode(',')];
            }

            if ('medical_conditions' == $key) {
                $rules['qa.' . $key] = ['required_if:qa.medical_agreement,yes,not sure'];
            }

            if ('occupation' == $key) {
                $rules['qa.' . $key] = ['required_if:qa.confirm_occupation,no'];
            }
        }

        $data = Validator::make(
            $input,
            $rules,
            [
                'qa.*.required' => 'This answer is required.',
                'qa.*.required_if' => 'This answer is required.',
                'qa.*.in' => 'This answer is invalid.',
            ],
            [
                'adviser_id' => 'Adviser',
                'is_new_client' => 'New Client',
                'client_id' => 'Client',
                'policy_holder' => 'Policy Holder',
                'policy_no' => 'Policy Number',
                'lead_source' => 'Lead Source',
                'qa' => 'Answers',
                'aq.*' => 'Answer',
            ]
        )->validate();

        if ('yes' == $data['is_new_client']) {
            $client = Client::create(collect($data)->only(['policy_holder', 'policy_no'])->all());
            $data['client_id'] = $client->id;
        }

        unset($data['is_new_client'], $data['policy_holder'], $data['policy_no']);

        $data['updated_by'] = Auth::user()->id;

        $audit->update($data);

        return $audit;
    }
}
