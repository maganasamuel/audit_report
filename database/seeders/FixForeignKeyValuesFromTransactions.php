<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FixForeignKeyValuesFromTransactions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::connection('mysql_training')->table('ta_user')
            ->whereRaw('right(email_address, ' . Str::length(config('services.mail.domain')) . ') = ?', config('services.mail.domain'))
            ->groupBy('email_address')
            ->select([
                'email_address',
                DB::raw('group_concat(id_user order by id_user desc) as ids'),
                DB::raw('count(id_user) as id_count'),
            ])->get();

        $dump = collect($users)->where('id_count', '>', 1)->map(function ($user) {
            $ids = explode(',', $user->ids);

            $id = array_shift($ids);

            $advisers = DB::table('audits')->whereIn('adviser_id', $ids)->update([
                'adviser_id' => $id,
            ]);

            $creators = DB::table('audits')->whereIn('created_by', $ids)->update([
                'created_by' => $id,
            ]);

            $updators = DB::table('audits')->whereIn('updated_by', $ids)->update([
                'updated_by' => $id,
            ]);

            return [
                'id' => $id,
                'ids' => $ids,
                'advisers' => $advisers,
                'creators' => $creators,
                'updators' => $updators,
            ];
        });

        Log::info($dump);
    }
}
