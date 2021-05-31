<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin Account',
            'email' => 'admin@mail.com',
            'status' => 'Active',
            'is_admin' => true,
            'password' => Hash::make('secret'),
        ]);

        User::factory()->create([
            'name' => 'User Account',
            'email' => 'user@mail.com',
            'status' => 'Active',
            'is_admin' => false,
            'password' => Hash::make('secret'),
        ]);
    }
}
