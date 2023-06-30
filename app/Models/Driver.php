<?php

namespace App\Models;

use App\Casts\PhoneParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "full_name",
        "phone",
        "email",
        "type_id",
        "car_numbers",
    ];

    protected $casts = [
//        'phone' => PhoneParser::class,
    ];

    public function machineType() {
        return $this->hasOne(Machine::class, 'id', 'type_id');
    }

    public function user() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
