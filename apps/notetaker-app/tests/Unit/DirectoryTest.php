<?php
namespace Tests\Unit;

use App\Models\Directory;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe("When creating a directory", function () {

    it("should throw an exception when the name is null", function () {
        Directory::create(['name' => null]);
    })->throws(Exception::class);

    it ("should create a directory with a name", function() {
        $directory = Directory::create(['name' => 'Folder']);
        expect($directory)->toBeInstanceOf(Directory::class)
            ->and($directory->id)->toBeOne()
            ->and($directory->name)->toBe("Folder");
    });

    it("should be possible to rename a Directory", function() {
        $directory = Directory::create(['name' => 'Folder']);

        $directory->name = "Folder 2";
        $directory->save();

        expect($directory)->toBeInstanceOf(Directory::class)
            ->and($directory->id)->toBeOne()
            ->and($directory->name)->toBe("Folder 2");
    });

    it("should be possible to delete a Directory", function() {
        $directory = Directory::create(['name' => 'Folder']);
        $directory->delete();
        expect(Directory::count())->toBe(0);
    });
});
