<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sa' => 'array',
    ];

    public function advisers()
    {
        return $this->belongsTo(Adviser::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }
}
