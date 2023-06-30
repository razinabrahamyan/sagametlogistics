<?php

namespace App\Models;

use App\Casts\Json;
use App\Casts\PhoneParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Query extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "status",
        "client_name",
        "departure_date",
        "phone",
        "need_call_client",
        "regular_client",
        "address",
        "address_points",
        "photos",
        "videos",
        "type_of_metal",
        "price",
        "weight",
        "weight_from",
        "weight_to",
        "oxygen_count",
        "loaders_count",
        "cutters_count",
        "drivers",
        "machines",
        "base_address",
        "is_client_need_video",
        "comment",
        "user_id",
        "access_token",
    ];

    protected $casts = [
        'phone' => PhoneParser::class,
        'photos' => Json::class,
        'videos' => Json::class,
        'machines' => Json::class,
        'address_points' => Json::class,
    ];

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function currentStatus()
    {
        return $this->hasOne(Status::class, 'id', 'status');
    }

    public function metal()
    {
        return $this->hasOne(MetalType::class, 'id', 'type_of_metal');
    }

    public function map()
    {
        return $this->hasMany(QueryMap::class, 'query_id', 'id');
    }

    public function driversData()
    {
        return $this->hasOne(QuerySendedMachines::class, 'query_id', 'id');
    }
}
