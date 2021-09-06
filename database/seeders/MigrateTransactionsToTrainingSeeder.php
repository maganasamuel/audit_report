<?php

namespace Database\Seeders;

use App\Models\Audit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateTransactionsToTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $advisers = Audit::groupBy('adviser_id')->pluck('adviser_id')->mapWithKeys(function ($adviserId) {
            $email = DB::table('advisers')->where('id', $adviserId)->first()->email;

            $adviser = DB::connection('mysql_training')
                ->table('ta_user')
                ->where('email_address', $email)
                ->whereNotIn('id_user_type', [1, 3, 7, 8])
                ->first();

            return [$adviserId => [
                'id' => $adviser->id_user ?? 0,
                'email' => $adviser->email_address ?? $email,
                'user_type' => in_array(($adviser->id_user_type ?? 0), [0, 1, 3, 7, 8]) ? ($adviser->id_user_type ?? 'adviser not found') : 'correct adviser',
            ]];
        });

        $users = Audit::select('created_by as user_id')->groupBy('user_id')->union(
            Audit::select('updated_by as user_id')->groupBy('user_id')
        )->orderBy('user_id')->pluck('user_id')->mapWithKeys(function ($userId) {
            $email = DB::table('users')->where('id', $userId)->first()->email;

            $user = DB::connection('mysql_training')
                ->table('ta_user')
                ->whereIn('id_user_type', [1, 7, 8])
                ->where('email_address', $email)
                ->first();

            return [$userId => [
                'id' => $user->id_user ?? 190,
                'email' => $user->email_address ?? $email,
                'user_type' => in_array(($user->id_user_type ?? 0), [1, 7, 8]) ? 'correct user' : ($user->id_user_type ?? 'user not found'),
            ]];
        });

        Log::info($advisers);

        Log::info($users);

        foreach ($advisers as $adviser_id => $adviser) {
            Audit::where('adviser_id', $adviser_id)->update([
                'adviser_id' => $adviser['id'],
            ]);
        }

        foreach ($users as $user_id => $user) {
            Audit::where('created_by', $user_id)->update([
                'created_by' => $user['id'],
            ]);

            Audit::where('updated_by', $user_id)->update([
                'updated_by' => $user['id'],
            ]);
        }
    }
}
