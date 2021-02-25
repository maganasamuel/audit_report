<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Account',
            'email' => 'admin@mail.com',
            'status' => 'Active',
            'is_admin' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $faker = Faker::create();

        $gender = $faker->randomElement(['male', 'female']);

        foreach(range(1, 10) as $index){
            DB::table('users')->insert([
                'name' => $faker->name($gender),
                'email' => $faker->email,
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_admin' => $faker->boolean($chanceOfGettingTrue = 50),
            ]);
        }
    }
}
