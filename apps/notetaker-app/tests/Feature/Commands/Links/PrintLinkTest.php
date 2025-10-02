<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\artisan;

uses(RefreshDatabase::class);

describe('links:print => Show details for a Link ', function () {

    beforeEach(function () {
        Link::factory()->forDirectory(['name' => 'Default'])->create([
            'url' => 'https://80hd.dev/test-driven-development-and-adhd/',
            'title' => 'Test driven development and adhd'
        ]);
    });

    it("should fail if unvalid id", function() {
        $this->artisan("links:print 5")
            ->expectsOutput('Link not found.')
            ->assertFailed();
    });

    describe("without reviews or quote", function () {

        it("should show the name and the URL of the Link", function () {
            $this->artisan("links:print 1")
                ->expectsOutput("[1] Test driven development and adhd (https://80hd.dev/test-driven-development-and-adhd/)")
                ->expectsOutput("=========================================================================================")
                ->expectsOutput("0 quote / 0 review")
                ->expectsOutput("  To add a quote : links:quote 1 \"Your quote\" (--author=\"Author Name\")")
                ->expectsOutput("  To add a review : links:review 1 \"Your review\"")
                ->assertSuccessful();
        });
    });
});
