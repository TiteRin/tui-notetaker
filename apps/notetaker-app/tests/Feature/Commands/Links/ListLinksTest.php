<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("List links", function () {

    it("should return \"no links\" if no links exist", function () {
        $this->artisan("links:list")
            ->expectsOutput("No links found")
            ->assertSuccessful();
    });

    it("should return the number of links", function () {

        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://google.com"]);
        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://google.com"]);
        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://google.com"]);

        $this->artisan("links:list")
            ->expectsOutput("3 links found")
            ->assertSuccessful();
    });

    it("should return an array of links", function () {
        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://google.com"]);
        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://example.com"]);
        Link::factory()->forDirectory(['name' => 'Folder'])->create(["url" => "https://localhost"]);

        $this->artisan("links:list")
            ->expectsTable(
                ["ID", "Url"], [
                [1, "https://google.com"],
                [2, "https://example.com"],
                [3, "https://localhost"],
            ])
            ->assertSuccessful();
    });
});
