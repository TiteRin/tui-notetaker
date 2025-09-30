<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\DateFactory;

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

    it("should return an array of links with all columns", function () {
        $directory = Directory::factory()->create();
        $dateTime = fake()->dateTime();
        Link::factory()->for($directory)->create([
            "url" => "https://google.com",
            'title' => 'Google',
            'slug' => 'google',
            'created_at' => $dateTime
        ]);
        Link::factory()->for($directory)->create([
            "url" => "https://google.com",
            'title' => 'Google',
            'slug' => 'google-2',
            'created_at' => $dateTime
        ]);
        Link::factory()->for($directory)->create([
            "url" => "https://example.com",
            'title' => 'Example',
            'slug' => 'example',
            'created_at' => $dateTime
        ]);

        $this->artisan("links:list")
            ->expectsTable(
                ["ID", "Title", "Url", "Slug", "Directory", "Created At"], [
                [1, 'Google', 'https://google.com', 'google', $directory->getIconAndName(), $dateTime->format("Y-m-d H:i:s")],
                [2, 'Google', 'https://google.com', 'google-2', $directory->getIconAndName(), $dateTime->format("Y-m-d H:i:s")],
                [3, 'Example', 'https://example.com', 'example', $directory->getIconAndName(), $dateTime->format("Y-m-d H:i:s")]
            ])
            ->assertSuccessful();
    });
});
