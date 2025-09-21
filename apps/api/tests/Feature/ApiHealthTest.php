<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;

it("returns API health status", function () {
    $response = $this->get("/api/health");
    $response->assertOk()
        ->assertJson(
            function (AssertableJson $json) {
                return $json->has("status")
                    ->where("status", "ok");
            }
        );
});
