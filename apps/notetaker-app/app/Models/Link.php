<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use App\Casts\UrlCast;
use App\ValueObjects\Url;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ApiResource]
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = ['url'];

    protected $casts = [
        'url' => UrlCast::class,
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
