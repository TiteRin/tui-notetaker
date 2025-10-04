<?php

namespace Tests\Feature;

use App\Models\Directory;
use App\Models\Link;
use App\Models\Quote;
use App\Models\Review;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

uses(RefreshDatabase::class);

describe("Initialization", function () {

    it("should have a url", function () {
        $url = fake()->url();
        $link = Link::factory()->make(['url' => $url]);
        expect($link->url)->toEqual($url);
    });

    it("should throw an exception when the url is empty", function () {
        Link::factory()->create(['url' => '']);
    })->throws(InvalidArgumentException::class, "URL cannot be empty");

    it("should throw an exception if the url is not valid", function () {
        Link::factory()->create(['url' => 'not-a-url']);
    })->throws(InvalidArgumentException::class, "Invalid URL: not-a-url");

    it("should throw an exception if there’s no Directory", function() {
        $link = Link::factory()->create(['url' => 'http://google.com']);
    })->throws(Exception::class);

    it("should create a Link with a valid URL", function () {
        $link = Link::factory()
            ->forDirectory(["name" => "Folder"])
            ->create(['url' => 'http://google.com']);
        expect($link)->toBeInstanceOf(Link::class)
            ->and($link->id)->not->toBeNull()
            ->and($link->url)->toEqual('http://google.com');
    });
});

describe("when updating a Link", function () {

    beforeEach(function () {
        $this->link = Link::factory()
            ->forDirectory(['name' => 'Folder'])
            ->create(['url' => 'http://google.com']);
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
            ->and($this->link->url)->toEqual('http://example.com');
    });
});

describe("When deleting a Link", function () {

    beforeEach(function () {
        $this->link = Link::factory()
            ->forDirectory(['name' => 'Folder'])
            ->create(['url' => 'http://google.com']);
    });

    it("should delete from the database", function () {
        $this->link->delete();
        expect(Link::count())->toBe(0);
    });
});

it("should computes total_reviews_count including link and quote reviews", function() {

    $link = Link::factory()->for(Directory::factory()->create())->create();
    Review::factory()->count(2)->for($link, 'reviewable')->create();
    Review::factory()->count(3)->for(
        Quote::factory()->for($link)->create(),
        'reviewable'
    )->create();
    Review::factory()->count(1)->for(
        Quote::factory()->for($link)->create(),
        'reviewable'
    )->create();

//    $linkWithCount = Link::withCount('reviews', 'quotes.reviews')->find($link->id);

    $linkWithCount = Link::withReviewsCount()->find($link->id);
    expect($linkWithCount->reviews_count)->toBe(2)
        ->and($linkWithCount->quotes_count)->toBe(2)
        ->and($linkWithCount->total_reviews_count)->toBe(6);
});
