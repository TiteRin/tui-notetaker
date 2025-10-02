<?php

namespace Tests\Unit;

use App\Models\Directory;
use App\Models\Link;
use App\Models\Review;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('When creating a review', function () {

    it('should throw an exception when the content is null', function () {
        $directory = Directory::factory()->create();
        $link = Link::factory()->for($directory)->create();
        Review::create(['content' => null, 'reviewable_type' => \App\Models\Link::class, 'reviewable_id' => $link->id]);
    })->throws(Exception::class);

    it('should create a review with content and link', function () {
        $directory = Directory::factory()->create();
        $link = Link::factory()->for($directory)->create(['url' => 'https://example.com']);

        $review = Review::create(['content' => 'Great link', 'reviewable_type' => \App\Models\Link::class, 'reviewable_id' => $link->id]);

        expect($review)
            ->toBeInstanceOf(Review::class)
            ->and($review->id)->toBeOne()
            ->and($review->content)->toBe('Great link');

        // Link side (direct reviews)
        expect($link->reviews()->count())->toBe(1);
    });
});

describe('Updating a review', function () {
    beforeEach(function () {
        $this->directory = Directory::factory()->create();
        $this->link = Link::factory()->for($this->directory)->create();
        $this->review = Review::factory()->for($this->link, 'reviewable')->create(['content' => 'Old content']);
    });

    it('should be possible to update review content', function () {
        $this->review->content = 'New content';
        $this->review->save();

        expect($this->review->fresh()->content)->toBe('New content');
    });
});

describe('Deleting a review', function () {
    it('should be possible to delete a review', function () {
        $directory = Directory::factory()->create();
        $link = Link::factory()->for($directory)->create();
        $review = Review::factory()->for($link, 'reviewable')->create();

        expect(Review::count())->toBe(1);
        $review->delete();
        expect(Review::count())->toBe(0);
        expect($link->reviews()->count())->toBe(0);
    });
});
