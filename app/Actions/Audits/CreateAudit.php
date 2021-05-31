<?php

namespace App\Actions\Audits;

use App\Models\Audit;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateAudit
{
    public function create($input)
    {
        $rules = [
            'adviser_id' => ['required', 'exists:advisers,id'],
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
        }

        $data = Validator::make(
            $input,
            $rules,
            [
                'qa.*.required' => 'This answer is required.',
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

        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        $audit = Audit::create($data);

        return $audit;
    }
}
