<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuerySendedMachines extends Model
{
    use HasFactory;

    protected $fillable = ['query_id', 'drivers_data', 'su_status', 'created_at', 'updated_at'];

    protected $casts = [
        'drivers_data' => Json::class,
    ];
}
