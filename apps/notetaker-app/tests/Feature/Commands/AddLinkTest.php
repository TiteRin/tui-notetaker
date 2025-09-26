<?php

use App\Models\Link;
use App\ValueObjects\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("Add a new link", function () {

    beforeEach(function () {
        $this->url = "https://google.com";
    });

    it("adds a new link to the database", function () {

        $cli = $this->artisan("links:add", ["url" => $this->url])
            ->expectsOutputToContain("Link added [1] $this->url")
            ->assertSuccessful();

    });

    it("shouldn’t succeed if the url is empty", function () {
       $this->artisan("links:add", ["url" => ""])
            ->expectsOutputToContain("URL cannot be empty")
            ->assertFailed();
    });

    it("should’n succeed if the url is not valid", function() {
        $this->artisan("links:add", ["url" => "not-an-url"])
            ->expectsOutputToContain("Invalid URL")
            ->assertFailed();
    });
});
