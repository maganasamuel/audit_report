<?php

namespace Database\Seeders;

use App\Models\Audit;
use App\Models\Client;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $admin = User::where('is_admin', true)->first();

        $faker = Factory::create();

        Audit::factory(200)
            ->hasAttached(
                Client::inRandomOrder()->first() ?? Client::factory(),
                [
                    'weekOf' => date('Y-m-d'),
                    'lead_source' => $faker->randomElement(['Telemarketer', 'BDM', 'Self-generated']),
                    'pdf_title' => 'audit-report.pdf',
                ],
            )
            ->create([
                'user_id' => $admin->id,
            ]);
    }
}
