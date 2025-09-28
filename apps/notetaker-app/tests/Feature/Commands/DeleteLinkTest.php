<?php

namespace Tests\Feature\Commands;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("should send an error if trying to delete a non existing link", function () {
    $this->artisan("links:delete", ["id" => 1])
        ->expectsOutput("Link not found.")
        ->assertFailed();
});
