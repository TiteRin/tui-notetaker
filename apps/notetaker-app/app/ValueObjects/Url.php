<?php

namespace App\ValueObjects;

use InvalidArgumentException;

final class Url
{
    public function __construct(private readonly string $url) {
        $this->validate($url);
    }

    private function validate(string $url): void
    {
        if (empty($url)) {
            throw new InvalidArgumentException("URL cannot be empty");
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: $url");
        }
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
