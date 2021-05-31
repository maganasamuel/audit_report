<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUser
{
    public function update($input, User $user)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user),
                'max:255',
            ],
            'status' => ['required', 'in:Active,Deactivated'],
            'is_admin' => ['required', 'boolean'],
        ], [], [
            'name' => 'Name',
            'email' => 'E-Mail',
            'status' => 'Status',
            'is_admin', 'Admin Privileges',
        ])->validate();

        $user->update($data);

        return $user;
    }
}
