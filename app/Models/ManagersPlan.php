<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagersPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'all_calls_plan',
        'outgoing_calls_plan',
        'incoming_calls_plan',
        'outgoing_calls',
        'incoming_calls',
        'manager_id',
        'managers_calendar_id',
    ];
}
