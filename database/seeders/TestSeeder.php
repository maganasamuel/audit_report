<?php

namespace Database\Seeders;

use App\Models\Audit;
use App\Models\Client;
use App\Models\Survey;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        DB::select('DELETE FROM audit_client');
        DB::select('ALTER TABLE audit_client AUTO_INCREMENT=1');
        Survey::truncate();

        $admin = User::where('is_admin', true)->first();

        $faker = Factory::create();

        foreach (range(1, 200) as $index) {
            Audit::factory()
                ->hasAttached(
                    Client::inRandomOrder()->first() ?? Client::factory(),
                    [
                        'weekOf' => $faker->date(),
                        'lead_source' => $faker->randomElement(['Telemarketer', 'BDM', 'Self-generated']),
                        'pdf_title' => Str::slug($faker->jobTitle) . '.pdf',
                    ],
                )
                ->create([
                    'user_id' => $admin->id,
                ]);
        }

        Survey::factory(200)->create();
    }
}
