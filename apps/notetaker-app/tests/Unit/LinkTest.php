<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

uses(RefreshDatabase::class);

it("should have a url", function () {
    $url = fake()->url();
    $link = Link::factory()->make(['url' => $url]);
    expect($link->url)->toBe($url);
});

it("should throw an exception when the url is empty", function () {
    Link::factory()->create(['url' => '']);
})->throws(InvalidArgumentException::class, "URL cannot be empty");

it("should throw an exception if the url is not valid", function () {
    Link::factory()->create(['url' => 'not-a-url']);
})->throws(InvalidArgumentException::class, "Invalid URL: not-a-url");

it("should create a Link with a valid URL", function () {
    $link = Link::factory()->create(['url' => 'http://google.com']);
    expect($link)->toBeInstanceOf(Link::class)
        ->and($link->id)->not->toBeNull()
        ->and($link->url)->toBe('http://google.com');
});

describe("when updating a Link", function() {

    beforeEach(function() {
        $this->link = Link::factory()->create(['url' => 'http://google.com']);
    });

    it("should throw an exception when the url is empty", function () {
        $this->link->update(['url' => '']);
    })->throws(InvalidArgumentException::class, "URL cannot be empty");

    it("should throw an exception when the url is not valid", function () {
        $this->link->update(['url' => 'not-a-url']);
    })->throws(InvalidArgumentException::class, "Invalid URL: not-a-url");

    it("should update a Link with a valid URL", function () {
        $id = $this->link->id;
        $this->link->update(['url' => 'http://example.com']);
        expect($this->link)->toBeInstanceOf(Link::class)
            ->and($this->link->id)->toBe($id)
            ->and($this->link->url)->toBe('http://example.com');
    });
});
