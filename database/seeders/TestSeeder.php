<?php

namespace Database\Seeders;

use App\Models\Audit;
use App\Models\Survey;
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
        Audit::truncate();
        Survey::truncate();

        Audit::factory(200)->create();
        Survey::factory(200)->create();
    }
}
