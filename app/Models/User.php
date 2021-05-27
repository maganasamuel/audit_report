<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Survey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createdAudits()
    {
        return $this->hasMany(Audit::class, 'created_by');
    }

    public function updatedAudits()
    {
        return $this->hasMany(Audit::class, 'updated_by');
    }

    public function createdSurveys()
    {
        return $this->hasMany(Survey::class, 'created_by');
    }

    public function updatedSurveys()
    {
        return $this->hasMany(Survey::class, 'updated_by');
    }
}
