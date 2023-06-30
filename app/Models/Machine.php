<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model {
    use HasFactory;

    protected $fillable = [
        "title"
    ];

    public function drivers(){
        return $this->hasMany(Driver::class, 'type_id', 'id');
    }
}
