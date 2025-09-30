<?php
namespace Tests\Feature\Commands\Reviews;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('List reviews for a Link and a Directory', function () {

    beforeEach(function () {
        $this->directory = Directory::factory()->create(['name' => 'Folder']);
        $this->link1 = Link::factory()->for($this->directory)->create(['url' => 'https://a.com']);
        $this->link2 = Link::factory()->for($this->directory)->create(['url' => 'https://b.com']);
    });

    it('links:reviews should display no review if none', function () {
        $this->artisan("links:reviews {$this->link1->id}")
            ->expectsOutput("No reviews found for link [{$this->link1->id}] {$this->link1->url}")
            ->assertSuccessful();
    });

    it('links:reviews should list reviews for a link', function () {
        // create reviews
        \DB::table('reviews')->insert([
            ['content' => 'Nice', 'link_id' => $this->link1->id, 'created_at' => now(), 'updated_at' => now()],
            ['content' => 'Great', 'link_id' => $this->link1->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->artisan("links:reviews {$this->link1->id}")
            ->expectsTable(['ID','Content'], [
                ['1', 'Nice'],
                ['2', 'Great'],
            ])
            ->assertSuccessful();
    });

    it('directory:reviews should group reviews by link', function () {
        \DB::table('reviews')->insert([
            ['content' => 'L1 A', 'link_id' => $this->link1->id, 'created_at' => now(), 'updated_at' => now()],
            ['content' => 'L1 B', 'link_id' => $this->link1->id, 'created_at' => now(), 'updated_at' => now()],
            ['content' => 'L2 A', 'link_id' => $this->link2->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->artisan("directory:reviews {$this->directory->id}")
            ->expectsOutput("Directory [{$this->directory->id}] 📂 {$this->directory->name}")
            ->expectsOutput("Link [{$this->link1->id}] {$this->link1->url} - 2 reviews")
            ->expectsTable(['ID','Content'], [
                ['1','L1 A'],
                ['2','L1 B'],
            ])
            ->expectsOutput("Link [{$this->link2->id}] {$this->link2->url} - 1 review")
            ->expectsTable(['ID','Content'], [
                ['3','L2 A'],
            ])
            ->assertSuccessful();
    });
});
