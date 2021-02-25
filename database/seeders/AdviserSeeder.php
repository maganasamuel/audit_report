<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdviserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $gender = $faker->randomElement(['male', 'female']);

        foreach(range(1, 200) as $index){
            DB::table('advisers')->insert([
                'name' => $faker->name($gender),
                'fsp_no' => $faker->randomNumber(5),
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
