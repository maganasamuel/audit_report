<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $user;
    }
}
