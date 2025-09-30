<?php
namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Add link with title and slug', function () {
    it('should accept --title and generate slug from it', function () {
        $this->artisan('links:add https://example.com --directory=Folder --title="My Page"')
            ->expectsOutputToContain('Link added [1] https://example.com [📂 Folder]')
            ->assertSuccessful();

        $link = Link::first();
        expect($link->title)->toBe('My Page');
        expect($link->slug)->toBe('my-page');
        expect($link->directory->name)->toBe('Folder');
    });
});
