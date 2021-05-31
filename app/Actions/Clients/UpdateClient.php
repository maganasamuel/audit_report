<?php

namespace App\Actions\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class UpdateClient
{
    public function update($input, Client $client)
    {
        $data = Validator::make($input, [
            'policy_holder' => ['required', 'string', 'max:255'],
            'policy_no' => ['required', 'string', 'max:255'],
        ], [], [
            'policy_holder' => 'Policy Holder',
            'policy_no' => 'Policy Number',
        ])->validate();

        $client->update($data);

        return $client;
    }
}
