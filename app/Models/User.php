<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $connection = 'mysql_training';

    protected $table = 'ta_user';

    protected $primaryKey = 'id_user';

    protected $hidden = ['password'];

    protected $guarded = ['password'];

    public function getIsAdminAttribute()
    {
        return 1 == $this->id_user_type;
    }

    public function createdAudits()
    {
        return $this->hasMany(Audit::class, 'created_by', 'id_user');
    }

    public function updatedAudits()
    {
        return $this->hasMany(Audit::class, 'updated_by', 'id_user');
    }

    public function createdSurveys()
    {
        return $this->hasMany(Survey::class, 'created_by', 'id_user');
    }

    public function updatedSurveys()
    {
        return $this->hasMany(Survey::class, 'updated_by', 'id_user');
    }

    protected static function booted()
    {
        static::addGlobalScope('admin_sadr_adr', function (Builder $builder) {
            $builder->whereRaw('(SELECT u.id_user FROM ta_user AS u WHERE u.email_address = ta_user.email_address ORDER BY u.id_user DESC LIMIT 1) = ta_user.id_user')
                ->whereRaw('right(email_address, ' . Str::length(config('services.mail.domain')) . ') = ?', config('services.mail.domain'))
                ->whereIn('id_user_type', config('services.user_types'));
        });
    }
}
