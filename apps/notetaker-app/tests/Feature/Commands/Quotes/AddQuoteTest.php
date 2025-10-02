<?php
namespace Tests\Feature\Commands\Quotes;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Add a Quote to a Link', function () {
    it('should add a quote with optional author and print message', function () {
        $directory = Directory::factory()->create(['name' => 'Folder']);
        $link = Link::factory()->for($directory)->create(['url' => 'https://a.com', 'title' => 'Site A']);

        $this->artisan("links:quote {$link->id} \"To be or not to be\" --author=Shakespeare")
            ->expectsOutputToContain('The quote [1] "To be or not to be" has been added to Site A')
            ->assertSuccessful();
    });

    it('should fallback to url when link has no title', function () {
        $directory = Directory::factory()->create(['name' => 'Folder']);
        $linkId = \DB::table('links')->insertGetId([
            'url' => 'https://b.com',
            'directory_id' => $directory->id,
            'title' => null,
            'slug' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan("links:quote {$linkId} 'Quote only'")
            ->expectsOutputToContain('The quote [1] "Quote only" has been added to https://b.com')
            ->assertSuccessful();
    });
});
