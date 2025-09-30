<?php
namespace Tests\Feature\Commands\Reviews;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Add a review to a link', function () {

    beforeEach(function () {
        $this->directory = Directory::factory()->create(['name' => 'Folder']);
        $this->link = Link::factory()->for($this->directory)->create(['url' => 'https://example.com']);
    });

    it('should fail if content is empty', function () {
        $this->artisan('reviews:add', ['review' => ''])
            ->expectsOutputToContain('Review content cannot be empty')
            ->assertFailed();
    });

    it('should fail if link is missing', function () {
        $this->artisan('reviews:add', ['review' => 'Great link!'])
            ->expectsOutputToContain('Missing link, use --link to target a link ID')
            ->assertFailed();
    });

    it('should fail if link does not exist', function () {
        $this->artisan('reviews:add "Great link!" --link=999')
            ->expectsOutputToContain('Link not found')
            ->assertFailed();
    });

    it('should add a review to a link', function () {
        $this->artisan("reviews:add 'Great link!' --link={$this->link->id}")
            ->expectsOutputToContain("Review added [1] to Link [{$this->link->id}] https://example.com")
            ->assertSuccessful();
    });
});
