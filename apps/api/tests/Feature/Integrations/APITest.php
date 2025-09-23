<?php

namespace Tests\Feature\Integrations;

use ApiPlatform\Laravel\Test\ApiTestAssertionsTrait;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(ApiTestAssertionsTrait::class);
uses(RefreshDatabase::class);

describe("when calling the links API", function () {

    it("returns a 406 status", function() {
        $this->getJson('/api/links')
        ->assertStatus(406);
    });

    it("should return a 200 status code", function () {
        $this->getJson('/api/links', [
            'Accept' => 'application/ld+json',
            'Content-Type' => 'application/ld+json',
        ])->assertOk();
    });

//    it('should return a list of links', function () {
//        Link::factory()->count(100)->create();
//
//        $links = $this->getJson('/api/links', [
//            'Accept' => 'application/ld+json',
//            'Content-Type' => 'application/ld+json',
//        ]);
//
//        $links->assertStatus(200);
//    });
});
