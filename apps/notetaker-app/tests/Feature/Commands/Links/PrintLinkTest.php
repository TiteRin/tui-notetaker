<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use App\Models\Quote;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\artisan;

uses(RefreshDatabase::class);

describe('links:print => Show details for a Link ', function () {

    beforeEach(function () {
        $this->link = Link::factory()->forDirectory(['name' => 'Default'])->create([
            'url' => 'https://80hd.dev/test-driven-development-and-adhd/',
            'title' => 'Test driven development and adhd'
        ]);
    });

    it("should fail if unvalid id", function () {
        $this->artisan("links:print 5")
            ->expectsOutput('Link not found.')
            ->assertFailed();
    });

    it("should show the name and the URL of the Link, and a 0/0 numbers of quotes and reviews", function () {
        $this->artisan("links:print 1")
            ->expectsOutput("[1] Test driven development and adhd (https://80hd.dev/test-driven-development-and-adhd/)")
            ->expectsOutput("=========================================================================================")
            ->expectsOutput("0 quotes / 0 reviews")
            ->expectsOutput("  To add a quote : links:quote 1 \"Your quote\" (--author=\"Author Name\")")
            ->expectsOutput("  To add a review : links:review 1 \"Your review\"")
            ->assertSuccessful();
    });

    it("should show the numbers of quotes and reviews (total)", function () {

        Review::factory()->count(3)->for($this->link, 'reviewable')->create();
        Quote::factory()->count(2)->for($this->link)->create();

        Review::factory()->for(
            Quote::factory()->for($this->link), 'reviewable'
        )->create();

        Review::factory()->count(2)->for(
            Quote::factory()->for($this->link), 'reviewable'
        )->create();

        $this->artisan("links:print 1")
            ->expectsOutput("4 quotes / 6 reviews")
            ->assertSuccessful();
    });

});
