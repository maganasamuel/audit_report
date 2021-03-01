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
}
