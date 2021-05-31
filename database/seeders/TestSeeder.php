<?php

namespace Database\Seeders;

use App\Models\Audit;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'inactive-user@mail.com',
            'status' => 'Deactivated',
        ]);

        Audit::truncate();
        Survey::truncate();

        Audit::factory(200)->create();
        Survey::factory(200)->create();
    }
}
