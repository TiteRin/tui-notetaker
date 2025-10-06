<?php

namespace Tests\Feature\Commands\Links;

use App\Models\Directory;
use App\Models\Link;
use App\Models\Quote;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\artisan;

uses(RefreshDatabase::class);

describe('links:print => Show details for a Link ', function () {

    beforeEach(function () {
        $this->link = Link::factory()->forDirectory(['name' => 'Default'])->create([
            'url' => 'https://80hd.dev/test-driven-development-and-adhd/',
            'title' => 'Test driven development and adhd'
        ]);
    });

    it("should fail if unvalid id", function () {
        $this->artisan("links:print 5")
            ->expectsOutput('Link not found.')
            ->assertFailed();
    });

    it("should show the name and the URL of the Link, and a 0/0 numbers of quotes and reviews", function () {
        $this->artisan("links:print 1")
            ->expectsOutput("[1] Test driven development and adhd (https://80hd.dev/test-driven-development-and-adhd/)")
            ->expectsOutput("=========================================================================================")
            ->expectsOutput("0 quotes / 0 reviews")
            ->expectsOutput("  To add a quote : links:quote 1 \"Your quote\" (--author=\"Author Name\")")
            ->expectsOutput("  To add a review : links:review 1 \"Your review\"")
            ->assertSuccessful();
    });

    it("should show the numbers of quotes and reviews (total)", function () {

        Review::factory()->count(3)->for($this->link, 'reviewable')->create();
        Quote::factory()->count(2)->for($this->link)->create();

        Review::factory()->for(
            Quote::factory()->for($this->link), 'reviewable'
        )->create();

        Review::factory()->count(2)->for(
            Quote::factory()->for($this->link), 'reviewable'
        )->create();

        $this->artisan("links:print 1")
            ->expectsOutput("4 quotes / 6 reviews")
            ->assertSuccessful();
    });

    it("should print Link’s Reviews and Quotes in created_at order", function () {

        Review::factory()->for($this->link, 'reviewable')->create(
            [
                'content' => 'An article about TDD and ADHD, with examples',
            ]
        );

        sleep(1);

        $quote = Quote::factory()
            ->for($this->link)
            ->create([
                'content' => 'Large tasks, vague requirements, and long debugging sessions create mental roadblocks ' .
                    'that make it hard to start, stay on track, or finish without distraction.'
            ]);

        Review::factory()
            ->for($quote, 'reviewable')
            ->create([
                'content' => 'Executive dysfunction, hard to keep on track',
            ]);

        sleep(2);

        Quote::factory()
            ->for($this->link)
            ->create([
                'content' => 'ADHD affects the way we approach complex problems. We often experience:
- Cognitive Overload – Trying to hold too many details in our heads at once leads to mental exhaustion.
- Decision Paralysis – Not knowing where to start makes it difficult to begin coding.
- Hyper-Focus – Diving deep into code can spiral into endless rabbit holes.'
            ]);

        sleep(1);

        $quote2 = Quote::factory()
            ->for($this->link)
            ->create([
                'content' => 'Instead of trying to solve an entire problem in one go, TDD forces you to focus ' .
                    'on just one small step at a time.'
            ]);

        sleep(1);

        Review::factory()->for($this->link, 'reviewable')
            ->create([
                'content' => 'TDD permet d’alléger la charge cognitive, la dysfonction exécutive et fournit' .
                    ' des récompenses rapides. '
            ]);

        $this->artisan("links:print 1")
            ->expectsOutput('')
            ->expectsOutput('[Review 1]')
            ->expectsOutputToContain('# An article about TDD and ADHD, with examples')
            ->expectsOutput('')
            ->expectsOutput('[Quote 1]')
            ->expectsOutputToContain('> Large tasks, vague requirements, and long debugging sessions create mental roadblocks that make it hard to start, stay on track, or finish without distraction.')
            ->expectsOutputToContain('[Review 2]')
            ->expectsOutputToContain(' - Executive dysfunction, hard to keep on track')
            ->expectsOutput('')
            ->expectsOutput("[Quote 2]")
            ->expectsOutputToContain('> ADHD affects the way we approach complex problems. We often experience:')
            ->expectsOutput('')
            ->expectsOutput("[Quote 3]")
            ->expectsOutputToContain('> Instead of trying to solve an entire problem in one go, TDD forces you to focus')
            ->expectsOutput('')
            ->expectsOutput('[Review 3]')
            ->expectsOutputToContain('# TDD permet d’alléger la charge cognitive, la dysfonction exécutive et fournit')
            ->expectsOutput('')
            ->assertSuccessful();

    });

});
