<?php

namespace App\Casts;

use App\ValueObjects\Url;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UrlCast implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): Url
    {
        return new Url($value);
    }

    public function set($model, string $key, mixed $value, array $attributes): string
    {
        $url = $value instanceof Url ? $value->url : new Url($value);
        return $url->url;
    }
}
