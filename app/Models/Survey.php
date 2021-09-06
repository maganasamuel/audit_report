<?php

namespace App\Models;

use App\Models\Adviser;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = [];

    protected $casts = [
        'sa' => 'array',
        'call_attempts' => 'array',
    ];

    public function adviser()
    {
        return $this->belongsTo(Adviser::class, 'adviser_id', 'id_user');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }
}
