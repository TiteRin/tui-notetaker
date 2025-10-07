<?php
namespace Tests\Unit;

use App\ValueObjects\Url;
use InvalidArgumentException;

it("should create a valid url", function() {
   $url = new Url("https://www.google.com");
   expect("https://www.google.com")->toBe((string) $url);
});

it("should throw an exception if url is empty", function() {
    $url = new Url("");
})->throws(InvalidArgumentException::class, "URL cannot be empty");

it("should throw an exception if url is not a valid url", function() {
    $url = new Url("not-a-url");
})->throws(InvalidArgumentException::class, "Invalid URL: not-a-url");
