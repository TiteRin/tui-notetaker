<?php

namespace Tests\Feature\Commands;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("should send an error if trying to delete a non existing link", function () {
    $this->artisan("links:delete", ["id" => 1])
        ->expectsOutput("Link not found.")
        ->assertFailed();
});

it("should display the link and ask for confirmation", function () {

    $link = Link::factory()->create(['url' => 'http://google.com']);

    $this->artisan("links:delete", ["id" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]")
        ->assertSuccessful();
});

it("when cancelling, link should not be deleted", function () {
    $link = Link::factory()->create(['url' => 'http://google.com']);

    $this->artisan("links:delete", ["id" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]", "no")
        ->expectsOutput("Deletion canceled.")
        ->assertSuccessful();
});

it("when confirming, link should be deleted", function () {
    $link = Link::factory()->create(['url' => 'http://google.com']);

    $this->artisan("links:delete", ["id" => $link->id])
        ->expectsConfirmation("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]", "yes")
        ->expectsOutput("Link deleted.")
        ->assertSuccessful();
});
