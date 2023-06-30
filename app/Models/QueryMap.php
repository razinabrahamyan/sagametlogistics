<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryMap extends Model
{
    use HasFactory;

    protected $casts = [
        "data" => Json::class,
    ];

    public function mapStatus()
    {
        return $this->hasOne(Status::class, 'id', 'status');
    }

    public function mapUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
