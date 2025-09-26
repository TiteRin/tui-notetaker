<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

#[ApiResource]
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = ['url'];

    public static function booted(): void
    {
        static::creating(function (Link $link) {
            $link->validate();
        });

        static::updating(function (Link $link) {
            $link->validate();
        });
    }

    protected function validate(): void
    {
        if (empty($this->url)) {
            throw new InvalidArgumentException("URL cannot be empty");
        }

        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: $this->url");
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
