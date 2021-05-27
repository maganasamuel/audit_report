<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Adviser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fsp_no',
        'status',
    ];

    protected $casts = [
        'sa' => 'array',
    ];

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function filterAudits($dateStart, $dateEnd)
    {
        return $this->audits()->whereBetween('created_at', [
            Carbon::parse($dateStart)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($dateEnd)->endOfDay()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get all total clients
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return int
     */
    public function totalClients($dateStart, $dateEnd)
    {
        return $this->filterAudits($dateStart, $dateEnd)->count();
    }

    /**
     * Average Adivser's service rate
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function serviceRating($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $sum = $audits->sum('qa->adviser_scale');

        return 0 == $sum ? 0 : ($sum / ($auditCount * 10)) * 100;
    }

    /**
     *
     * Disclousre of medical status
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function disclosurePercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->received_copy', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    /**
     * Bank account agreement percentage
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function paymentPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->bank_account_agreement', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    /**
     * Replaced Policy agreement percentage
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function policyReplacedPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->replace_policy', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    /**
     * Occupation agreement percentage
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function correctOccupationPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->confirm_occupation', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    /**
     * Compliance agreement percentage
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function compliancePercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->is_action_taken', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }

    /**
     * Replacement of policy agreement percentage
     *
     * @param mixed $dateStart
     * @param mixed $dateEnd
     *
     * @return double
     */
    public function replacementRisksPercentage($dateStart, $dateEnd)
    {
        $audits = $this->filterAudits($dateStart, $dateEnd);

        $auditCount = $audits->count();

        $count = $audits->where('qa->replacement_is_discussed', 'yes')->count();

        return 0 == $count ? 0 : ($count / $auditCount) * 100;
    }
}
