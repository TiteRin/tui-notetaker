<?php

namespace Tests\Unit;

use App\Models\Directory;
use App\Models\Link;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("When creating a directory", function () {

    it("should throw an exception when the name is null", function () {
        Directory::create(['name' => null]);
    })->throws(Exception::class);

    it("should create a directory with a name", function () {
        $directory = Directory::create(['name' => 'Folder']);
        expect($directory)->toBeInstanceOf(Directory::class)
            ->and($directory->id)->toBeOne()
            ->and($directory->name)->toBe("Folder");
    });

    it("should be possible to rename a Directory", function () {
        $directory = Directory::create(['name' => 'Folder']);

        $directory->name = "Folder 2";
        $directory->save();

        expect($directory)->toBeInstanceOf(Directory::class)
            ->and($directory->id)->toBeOne()
            ->and($directory->name)->toBe("Folder 2");
    });

    it("should be possible to delete a Directory", function () {
        $directory = Directory::create(['name' => 'Folder']);
        $directory->delete();
        expect(Directory::count())->toBe(0);
    });
});

describe("Deleting a directory", function () {

    beforeEach(function () {
        $this->directory = Directory::factory()->create();
    });

    it("should be possible to delete a directory", function() {
        $this->directory->delete();
    })->throwsNoExceptions();

    it("should not be possible to delete a directory containing links", function() {
        Link::factory()->count(3)->for($this->directory)->create();

        expect($this->directory->links()->count())->toBe(3);

        $this->directory->delete();
    })->throws(Exception::class);
});
