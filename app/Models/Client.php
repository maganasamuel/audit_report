<?php

namespace App\Models;

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
    public function audits(){
      return $this->belongsToMany(Audit::class)
                  ->withPivot('weekOf', 'lead_source', 'pdf_title')
                  ->withTimestamps();
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

    public function surveys(){
      return $this->hasMany(Survey::class);
    }
}
