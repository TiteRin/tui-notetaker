<?php

namespace Tests\Feature\Commands\Reviews;

use App\Models\Directory;
use App\Models\Link;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

describe('Reviews', function () {
    beforeEach(function () {
        $this->directory = Directory::factory()->create(['name' => 'Folder']);
        $this->link = Link::factory()->for($this->directory)->create(['url' => 'https://example.com']);
    });

    describe("Add a Review to a Link", function () {

        it('should add a review to a link with links:review', function () {
            $this->artisan("links:review {$this->link->id} 'Great!'")
                ->expectsOutputToContain('A new review [1] has been added to the link [1].')
                ->assertSuccessful();
        });

        it('should output an error message if the link doesn’t exist', function () {
            $this->artisan('links:review 5 "Not a great source"')
                ->expectsOutput("Link not found.")
                ->assertFailed();
        });

        it("should output un error message if the Review is empty", function () {
            $this->artisan("links:review 1 ''")
                ->expectsOutput("Review content cannot be empty.")
                ->assertFailed();
        });
    });

    describe("Add a Review to a Quote", function () {
        beforeEach(function () {
            $this->quote = Quote::factory()->for($this->link)->create();
        });

        it("should add a review to a quote with quote:review", function () {
            $this->artisan("quotes:review {$this->quote->id} 'Great !'")
                ->expectsOutput("A new review [1] has been added to the quote [1].")
                ->assertSuccessful();
        });

        it('should output an error message if the quote doesn’t exist', function () {
            $this->artisan('quotes:review 5 "Not a great quote"')
                ->expectsOutput("Quote not found.")
                ->assertFailed();
        });

        it("should output un error message if the Review is empty", function () {
            $this->artisan("quotes:review 1 ''")
                ->expectsOutput("Review content cannot be empty.")
                ->assertFailed();
        });
    });

//    it('should add a review to a quote with quotes:review and count under link', function () {
//        // add a quote
//        $this->artisan("links:quote {$this->link->id} 'A wise quote' --author=Anon")->assertSuccessful();
//
//        // add a review to the quote
//        $this->artisan('quotes:review 1 "Nice quote"')
//            ->expectsOutputToContain('The review [1] "Nice quote" has been added to the quote A wise quote')
//            ->assertSuccessful();
//
//        // directory:reviews should show 1 review for link now
//        $this->artisan("directory:reviews {$this->directory->id}")
//            ->expectsOutput("Link [{$this->link->id}] {$this->link->url} - 1 review")
//            ->assertSuccessful();
//    });
});
