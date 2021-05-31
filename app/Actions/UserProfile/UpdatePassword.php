<?php

namespace App\Actions\UserProfile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePassword
{
    public function update($input)
    {
        $validator = Validator::make($input, [
            'old_password' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ], [], [
            'old_password' => 'Old Password',
            'password' => 'New Password',
        ]);

        $validator->after(function ($validator) use ($input) {
            if (! (isset($input['old_password']) && Hash::check($input['old_password'], auth()->user()->password))) {
                $validator->errors()->add('old_password', 'Old password is invalid.');
            }
        });

        $data = $validator->validate();

        $password = $data['password'];

        auth()->user()->update([
            'password' => Hash::make($password),
        ]);
    }
}
