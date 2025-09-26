<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ApiResource]
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }
}
