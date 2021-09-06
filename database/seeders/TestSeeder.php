<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Survey;
use App\Models\User;
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
        $this->training();

        return;

        User::factory()->create([
            'email' => 'inactive-user@mail.com',
            'status' => 'Deactivated',
        ]);

        Audit::truncate();
        Survey::truncate();

        Audit::factory(200)->create();
        Survey::factory(200)->create();
    }

    public function training()
    {
        $audits = Audit::leftJoin(config('database.connections.mysql_training.database') . '.ta_user as adviser', 'audits.adviser_id', '=', 'adviser.id_user')
            ->select([
                'audits.*',
                DB::raw('concat(adviser.first_name, " ", adviser.last_name) as adviser_name'),
            ])->limit(5)->get();

        dd($audits->toArray());
    }
}
