<?php

namespace App\Actions\Advisers;

use App\Models\Adviser;
use Illuminate\Support\Facades\Validator;

class CreateAdviser
{
    public function create($input)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'fsp_no' => ['required', 'integer', 'min:1', 'max:999999999'],
            'contact_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'fap_name' => ['required', 'string', 'max:255'],
            'fap_email' => ['required', 'string', 'email', 'max:255'],
            'fap_fsp_no' => ['required', 'integer', 'min:1', 'max:999999999'],
            'fap_contact_number' => ['required', 'string', 'max:255'],
        ], [], [
            'name' => 'Name',
            'email' => 'Email',
            'fsp_no' => 'FSP Number',
            'contact_number' => 'Contact Number',
            'address' => 'Address',
            'fap_name' => 'FAP Name',
            'fap_email' => 'FAP Email',
            'fap_fsp_no' => 'FAP FSP Number',
            'fap_contact_number' => 'FAP Contact Number',
        ])->validate();

        $data['status'] = 'Active';

        $adviser = Adviser::create($data);

        return $adviser;
    }
}
