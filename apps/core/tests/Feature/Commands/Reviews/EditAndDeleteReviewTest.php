<?php
namespace Tests\Feature\Commands\Reviews;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Edit and Delete a review', function () {

    beforeEach(function () {
        $this->directory = Directory::factory()->create();
        $this->link = Link::factory()->for($this->directory)->create(['url' => 'https://c.com']);
        // seed one review id=1
        \DB::table('reviews')->insert([
            'id' => 1,
            'content' => 'Old',
            'reviewable_type' => \App\Models\Link::class,
                        'reviewable_id' => $this->link->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    });

    it('reviews:edit should update content', function () {
        $this->artisan('reviews:edit 1 "New Content"')
            ->expectsOutput('Review [1] updated')
            ->assertSuccessful();

        $this->artisan("links:reviews {$this->link->id}")
            ->expectsTable(['ID','Content'], [
                ['1','New Content'],
            ])
            ->assertSuccessful();
    });

    it('reviews:delete should delete the review', function () {
        $this->artisan('reviews:delete 1')
            ->expectsOutput('Review [1] deleted')
            ->assertSuccessful();

        $this->artisan("links:reviews {$this->link->id}")
            ->expectsOutput("No reviews found for link [{$this->link->id}] {$this->link->url}")
            ->assertSuccessful();
    });
});
