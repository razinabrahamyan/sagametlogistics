<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagersPlanCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'managers_ids',
        'plan_date'
    ];

    protected $casts = [
        'managers_ids' => Json::class,
    ];
}
