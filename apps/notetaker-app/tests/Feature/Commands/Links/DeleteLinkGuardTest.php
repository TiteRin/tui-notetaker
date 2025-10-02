<?php
namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Deleting a link that has reviews', function () {

    it('should not be possible to delete a link with reviews', function () {
        $directory = Directory::factory()->create();
        $link = Link::factory()->for($directory)->create(['url' => 'https://d.com']);
        \DB::table('reviews')->insert([
            'content' => 'Keep',
            'reviewable_type' => \App\Models\Link::class,
            'reviewable_id' => $link->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan("links:delete {$link->id}")
            ->expectsOutput('Cannot delete a link that has reviews.')
            ->assertFailed();
    });
});
