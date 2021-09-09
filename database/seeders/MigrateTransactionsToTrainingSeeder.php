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
        $this->fixDuplicates();

        $advisers = Audit::groupBy('adviser_id')->pluck('adviser_id')->mapWithKeys(function ($adviserId) {
            $email = DB::table('advisers')->where('id', $adviserId)->first()->email;

            $adviser = DB::connection('mysql_training')
                ->table('ta_user')
                ->where('email_address', $email)
                ->whereNotIn('id_user_type', config('services.not_user_types'))
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
                ->whereIn('id_user_type', config('services.user_types'))
                ->where('email_address', $email)
                ->first();

            return [$userId => [
                'id' => $user->id_user ?? 190,
                'email' => $user->email_address ?? $email,
                'user_type' => in_array(($user->id_user_type ?? 0), config('services.user_types')) ? 'correct user' : ($user->id_user_type ?? 'user not found'),
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

    public function fixDuplicates()
    {
        $trainingAttendees = explode(
            ',',
            DB::connection('mysql_training')
                ->table('ta_training')
                ->pluck('training_attendee')
                ->implode(',')
        );

        $users = DB::connection('mysql_training')
            ->table('ta_user')->select([
                DB::raw('max(id_user) as id_user_max'),
                'email_address',
                DB::raw('count(id_user) as duplicate_role_count'),
                DB::raw('group_concat(id_user_type order by id_user desc) as roles'),
                DB::raw('group_concat(id_user order by id_user desc) as ids'),
            ])->groupBy('email_address', 'id_user_type')
            ->having('duplicate_role_count', '>', 1)
            ->orderBy('id_user_max', 'desc')
            ->get();

        foreach ($users as $user) {
            $ids = explode(',', $user->ids);

            $user->id_user = array_shift($ids);

            $user->duplicate_ids = $ids;

            $user->duplicate_test_set_access = DB::connection('mysql_training')
                ->table('ta_trainer_test_set_access')
                ->whereIn('user_id', $user->duplicate_ids)
                ->groupBy('user_id')
                ->count();

            $user->duplicate_test = DB::connection('mysql_training')
                ->table('ta_test')
                ->whereIn('id_user_tested', $user->duplicate_ids)
                ->groupBy('id_user_tested')
                ->count();

            $user->duplicate_training_trainer = DB::connection('mysql_training')
                ->table('ta_training')
                ->whereIn('trainer_id', $user->duplicate_ids)
                ->groupBy('trainer_id')
                ->count();

            $user->duplicate_training_training_attendee = collect($trainingAttendees)->filter(function ($item) use ($user) {
                return in_array($item, $user->duplicate_ids);
            })->count();
        }

        collect($users)->where('duplicate_test_set_access', '>', 0)->each(function ($user) {
            DB::connection('mysql_training')
                ->table('ta_trainer_test_set_access')
                ->whereIn('user_id', $user->duplicate_ids)
                ->update([
                    'user_id' => $user->id_user,
                ]);
        });

        collect($users)->where('duplicate_test', '>', 0)->each(function ($user) {
            DB::connection('mysql_training')
                ->table('ta_test')
                ->whereIn('id_user_tested', $user->duplicate_ids)
                ->update([
                    'id_user_tested' => $user->id_user,
                ]);
        });

        collect($users)->where('duplicate_training_trainer', '>', 0)->each(function ($user) {
            DB::connection('mysql_training')
                ->table('ta_training')
                ->whereIn('training_id', $user->duplicate_ids)
                ->update([
                    'training_id' => $user->id_user,
                ]);
        });

        collect($users)->where('duplicate_training_training_attendee', '>', 0)->each(function ($user) {
            $trainings = DB::connection('mysql_training')
                ->table('ta_training')
                ->get();

            foreach ($trainings as $training) {
                $attendee = collect(explode(',', $training->training_attendee))->map(function ($item) use ($user) {
                    return in_array($item, $user->duplicate_ids) ? $user->id_user : $item;
                })->implode(',');

                DB::connection('mysql_training')
                    ->table('ta_training')
                    ->where('training_id', $training->training_id)
                    ->update([
                        'training_attendee' => $attendee,
                        'attendee_id' => $attendee,
                    ]);
            }
        });

        foreach ($users as $user) {
            DB::connection('mysql_training')
                ->table('ta_user')
                ->whereIn('id_user', $user->duplicate_ids)
                ->delete();
        }
    }
}
