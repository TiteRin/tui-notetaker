<?php
namespace Tests\Unit;

use App\Casts\UrlCast;
use App\ValueObjects\Url;

it("get should return a url object", function () {
    $cast = new UrlCast();
    $url = $cast->get(null, 'url', 'https://www.example.com', []);
    expect($url)->toBeInstanceOf(Url::class)
        ->and("https://www.example.com")->toBe((string) $url);
});

it("set should return a string", function () {
    $cast = new UrlCast();
    $url = $cast->set(null, 'url', 'https://www.example.com', []);
    expect($url)->toBe("https://www.example.com");
});
