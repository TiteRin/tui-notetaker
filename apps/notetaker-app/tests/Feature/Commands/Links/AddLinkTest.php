<?php

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("Add a new link", function () {

    beforeEach(function () {
        $this->url = "https://google.com";
    });

    it("shouldn’t succeed if the url is empty", function () {
        $this->artisan("links:add", ["url" => ""])
            ->expectsOutputToContain("URL cannot be empty")
            ->assertFailed();
    });

    it("shouldn’t succeed if the url is not valid", function () {
        $this->artisan("links:add", ["url" => "not-an-url"])
            ->expectsOutputToContain("Invalid URL")
            ->assertFailed();
    });

    it("shouldn’t succeed if the directory is missing", function () {
        $cli = $this->artisan("links:add", ["url" => $this->url])
            ->expectsOutputToContain("Missing directory, use -D or --directory to assign the link to a directory")
            ->assertFailed();
    });

    describe("adds a new link to the database", function () {

        test("should create a new link and a new directory", function () {
            $cli = $this->artisan("links:add $this->url --directory=Folder")
                ->expectsOutputToContain("Link added [1] $this->url [📂 Folder]")
                ->assertSuccessful();
        });
    });
});
