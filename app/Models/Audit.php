<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    public function clients(){
      return $this->belongsToMany(Client::class)
                  ->withPivot('weekOf', 'lead_source', 'pdf_title')
                  ->withTimestamps();
    }

    public function advisers(){
      return $this->hasMany(Adviser::class);    
    }

    public function users(){
      return $this->belongsTo(User::class);
    }
}