<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("should send an error if trying to delete a non existing link", function () {
    $this->artisan("links:delete", ["idOrSlug" => '9999'])
        ->expectsOutput("Link not found.")
        ->assertFailed();
});

it("should display the link and ask for confirmation by id", function () {

    $link = Link::factory()->forDirectory(['name' => 'Folder'])->create(['url' => 'http://google.com', 'slug' => 'google']);

    $this->artisan("links:delete", ["idOrSlug" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]")
        ->assertSuccessful();
});

it("should display the link and ask for confirmation by slug", function () {

    $link = Link::factory()->forDirectory(['name' => 'Folder'])->create(['url' => 'http://example.com', 'title' => 'Example']);
    $this->artisan("links:delete", ["idOrSlug" => $link->slug])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]")
        ->assertSuccessful();
});

it("when cancelling, link should not be deleted", function () {
    $link = Link::factory()->forDirectory(['name' => 'Folder'])->create(['url' => 'http://google.com', 'slug' => 'google']);

    $this->artisan("links:delete", ["idOrSlug" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]", "no")
        ->expectsOutput("Deletion canceled.")
        ->assertSuccessful();
});

it("when confirming, link should be deleted", function () {
    $link = Link::factory()->forDirectory(['name' => 'Folder'])->create(['url' => 'http://google.com', 'slug' => 'google']);

    $this->artisan("links:delete", ["idOrSlug" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]", "yes")
        ->expectsOutput("Link deleted.")
        ->assertSuccessful();
});
