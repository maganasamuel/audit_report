<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'qa' => 'array',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class)
            ->withPivot('weekOf', 'lead_source', 'pdf_title')
            ->withTimestamps();
    }

    public function adviser()
    {
        return $this->belongsTo(Adviser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
