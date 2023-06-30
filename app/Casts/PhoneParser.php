<?php

namespace App\Casts;

use App\Classes\Helpers\GF;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PhoneParser implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return GF::phoneToStr(GF::clearPhoneNumber($value));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return GF::clearPhoneNumber($value);
    }
}