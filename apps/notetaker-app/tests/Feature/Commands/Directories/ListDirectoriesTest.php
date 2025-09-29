<?php

namespace Tests\Feature\Commands\Directories;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("List Directories", function () {

    it("should return \"no directory\" if no directory exist", function () {
        $this->artisan("directories:list")
            ->expectsOutput("No directory found.")
            ->assertSuccessful();
    });

//    it("should return the number of links", function () {
//
//        Link::factory()->create(["url" => "https://google.com"]);
//        Link::factory()->create(["url" => "https://google.com"]);
//        Link::factory()->create(["url" => "https://google.com"]);
//
//        $this->artisan("links:list")
//            ->expectsOutput("3 links found")
//            ->assertSuccessful();
//    });
//
//    it("should return an array of links", function () {
//        Link::factory()->create(["url" => "https://google.com"]);
//        Link::factory()->create(["url" => "https://example.com"]);
//        Link::factory()->create(["url" => "https://localhost"]);
//
//        $this->artisan("links:list")
//            ->expectsTable(
//                ["ID", "Url"], [
//                [1, "https://google.com"],
//                [2, "https://example.com"],
//                [3, "https://localhost"],
//            ])
//            ->assertSuccessful();
//    });
});
