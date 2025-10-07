<?php

namespace Tests\Feature\Commands\Directories;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("List Directories", function () {

    it("should return \"no directory\" if no directory exist", function () {
        $this->artisan("directories:list")
            ->expectsOutput("No directory found.")
            ->assertSuccessful();
    });

    it("should return the number of directories", function () {

        Directory::factory()->count(3)->create();

        $this->artisan("directories:list")
            ->expectsOutput("3 directories found.")
            ->assertSuccessful();
    });

    it("should return an array of directories", function () {

        $default = Directory::create(["name" => "Default"]);
        Link::factory()->count(3)->forDirectory(["name" => "Test"])->create();
        Link::factory()->count(5)->forDirectory(["name" => "Cat"])->create();

        $this->artisan("directories:list")
            ->expectsTable(
                ["ID", "Name", "# Links"], [
                    ["1", "Default", "0"],
                    ["2", "Test", "3"],
                    ["3", "Cat", "5"],
            ])
            ->assertSuccessful();
    });
});
