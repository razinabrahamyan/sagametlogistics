<?php

namespace App\Models;

use App\Casts\PhoneParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HlrPhone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'phone',
    ];

    protected $casts = [
        'phone' => PhoneParser::class,
    ];
}
