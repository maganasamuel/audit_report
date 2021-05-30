<?php

namespace App\Models;

use App\Models\Audit;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Conducted audits on client
     *
     * @return App\Models\Audit
     */
    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    /**
     * Path of client
     *
     * @return string
     */
    public function path()
    {
        return '/profile/clients/' . $this->id;
    }
}
