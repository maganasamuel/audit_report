<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Adviser extends Model
{
    protected $connection = 'mysql_training';

    protected $table = 'ta_user';

    protected $primaryKey = 'id_user';

    protected $hidden = ['password'];

    protected $guarded = ['password'];

    public function audits()
    {
        return $this->hasMany(Audit::class, 'adviser_id', 'id_user');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'adviser_id', 'id_user');
    }

    public function filterAudits($dateStart, $dateEnd)
    {
        return $this->audits()->where(function ($query) use ($dateStart, $dateEnd) {
            $query->where('client_answered', 1)
                ->where('completed', 1)
                ->whereBetween('created_at', [
                    Carbon::parse($dateStart)->startOfDay()->format('Y-m-d H:i:s'),
                    Carbon::parse($dateEnd)->endOfDay()->format('Y-m-d H:i:s'),
                ]);
        });
    }

    public function totalClients($dateStart, $dateEnd)
    {
        return $this->filterAudits($dateStart, $dateEnd)->count();
    }

    public function serviceRating($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $sum = $audits->sum('qa->adviser_scale');

        return 0 == $sum ? 0 : ($sum / ($auditCount * 10)) * 100;
    }

    public function disclosurePercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->received_copy', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    public function paymentPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->bank_account_agreement', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    public function policyReplacedPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->replace_policy', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    public function correctOccupationPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->confirm_occupation', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    public function compliancePercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->is_action_taken', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    public function replacementRisksPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->replacement_is_discussed', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    protected static function booted()
    {
        static::addGlobalScope('adviser', function (Builder $builder) {
            $builder
                ->whereRaw('(SELECT u.id_user FROM ta_user AS u WHERE u.email_address = ta_user.email_address ORDER BY u.id_user DESC LIMIT 1) = ta_user.id_user')
                ->whereRaw('right(email_address, ' . Str::length(config('services.mail.domain')) . ') = ?', config('services.mail.domain'))
                ->whereNotIn('id_user_type', config('services.not_user_types'));
        });
    }
}
