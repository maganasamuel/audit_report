<?php

namespace Database\Seeders;

use App\Models\Adviser;
use Illuminate\Database\Seeder;

class AdviserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Alice', 'Adam', 'Alan'];

        foreach ($names as $name) {
            Adviser::factory()->create([
                'name' => $name,
            ]);
        }
    }
}
