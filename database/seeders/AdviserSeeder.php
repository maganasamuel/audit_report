<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdviserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('advisers')->insert([
        'name' => 'Adviser Test',
        'fsp_no' => 1234,
        'status' => 'Active',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
}
