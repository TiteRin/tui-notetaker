<?php

namespace Tests\Unit;

use App\Models\Link;

it("should have a url", function () {
    $url = fake()->url();
    $link = Link::factory()->make(['url' => $url]);
    expect($link->url)->toBe($url);
});
