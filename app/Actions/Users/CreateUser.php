<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CreateUser
{
    public function create($input)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'is_admin' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ], [], [
            'name' => 'Name',
            'email' => 'E-Mail',
            'is_admin', 'Admin Privileges',
        ])->validate();

        $data['status'] = 'Active';

        $user = User::create($data);

        return $user;
    }
}
