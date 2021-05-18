<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function audits(){
      return $this->belongsToMany(Audit::class)
                  ->withPivot('weekOf', 'lead_source', 'pdf_title')
                  ->withTimestamps();
    }

    public function surveys(){
      return $this->hasMany(Survey::class);
    }
}
