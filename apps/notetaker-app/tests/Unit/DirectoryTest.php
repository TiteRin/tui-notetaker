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
});
