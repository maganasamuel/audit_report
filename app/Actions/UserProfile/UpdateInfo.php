<?php

namespace App\Actions\UserProfile;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateInfo
{
    public function update($input)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()),
            ],
        ], [], [
            'name' => 'Name',
            'email' => 'E-Mail',
        ])->validate();

        auth()->user()->update($data);
    }
}
