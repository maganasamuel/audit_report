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
        Adviser::factory(200)->create();

        Adviser::factory()->create([
            'name' => 'Alice Alpha',
            'fsp_no' => 11111,
        ]);
    }
}
