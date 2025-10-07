<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

describe('Editing a Link', function () {
    beforeEach(function () {
        $this->link = Link::factory()
            ->forDirectory(['name' => 'Default'])
            ->create(
                [
                    'url' => 'https://www.google.com',
                    'title' => 'Google',
                    'slug' => 'google'
                ]
            );
    });

    it("should return a message when you don’t have a valid identifier", function() {
        $this->artisan("links:edit 2")
            ->expectsOutput("No Link found with this identifier [2].")
            ->assertOk();

        $this->artisan("links:edit gaagle")
            ->expectsOutput("No Link found with this identifier [gaagle].")
            ->assertOk();
    });

    it("should return a message if you don’t provide any option", function() {
        $this->artisan("links:edit google")
            ->expectsOutput("No options provided, use --set-title or --set-url. Edition canceled.")
            ->assertOk();
    });

    it("should edit the url of the link", function() {
        $this->artisan("links:edit 1 --set-url https://80hd.dev/test-driven-development-and-adhd/")
            ->expectsOutput("Link [1] edited : https://80hd.dev/test-driven-development-and-adhd/ (TDD is like a todo list that checks itself when you code)")
            ->assertSuccessful();
    });

    it("should edit the title of the link", function () {
        $this->artisan("links:edit 1 --set-title 'New Title'")
            ->expectsOutput("Link [1] edited : https://www.google.com (New Title)")
            ->assertSuccessful();
    });
});
