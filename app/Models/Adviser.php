<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fsp_no',
        'status',
    ];

    public function audits(){
      return $this->hasMany(Audit::class);
    }

    public function surveys(){
      return $this->hasMany(Survey::class);
    }

    /**
     * Get all total clients
     *
     * @return int
     */
    public function totalClients()
    {
      return count($this->audits->map(function($audit){

          return json_decode($audit->qa, true)['policy_no'];
      })->groupBy(function($value) {

          return $value;
      }));

    }

    /**
     * Average Adivser's service rate
     *
     * @return double
     */
    public function serviceRating()
    {
      $rating = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['adviser_scale'];

      })->sum();


      return $rating / count($this->audits);

    }

    /**
     * 
     * Disclousre of medical status
     *
     * @return double
     */
    public function disclosurePercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['medical_agreement'];

      })->sum(function($value) {

        return $value == 'yes - refer to notes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

    /**
     * Bank account agreement percentage
     *
     * @return double
     */
    public function paymentPercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['bank_account_agreement'];

      })->sum(function($value) {

        return $value == 'yes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

        /**
     * Replaced Policy agreement percentage
     *
     * @return double
     */
    public function policyReplacedPercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['replace_policy'];

      })->sum(function($value) {

        return $value == 'yes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

        /**
     * Occupation agreement percentage
     *
     * @return double
     */
    public function correctOccupationPercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['confirm_occupation'];

      })->sum(function($value) {

        return $value == 'yes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

    /**
     * Compliance agreement percentage
     *
     * @return double
     */
    public function compliancePercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['is_action_taken'];

      })->sum(function($value) {

        return $value == 'yes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

    /**
     * Replacement of policy agreement percentage
     *
     * @return double
     */
    public function replacementRisksPercentage()
    {
      $total = $this->audits->map(function($audit){

          return json_decode($audit->qa, true)['is_action_taken'];

      })->sum(function($value) {

        return $value == 'yes';
      });

      return $total == 0 ? 0 : ( ($total / count($this->audits)) * 100 );
    }

    public function audit($question, $answer)
    {
      
    }
}


