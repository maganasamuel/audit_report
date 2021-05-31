<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Charlie', 'Carl', 'Clark'];

        foreach ($names as $name) {
            Client::factory()->create([
                'policy_holder' => $name,
            ]);
        }
    }
}
