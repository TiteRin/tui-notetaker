<?php

namespace App\Console\Commands\Reviews;

use App\Models\Link;
use App\Models\Review;
use Illuminate\Console\Command;

class AddReview extends Command
{
    protected $signature = 'reviews:add {review} {--link=}';

    protected $description = 'Add a new review to a link';

    public function handle(): int
    {
        $content = (string) $this->argument('review');
        $linkId = $this->option('link');

        if (empty(trim($content))) {
            $this->error('Review content cannot be empty');
            return Command::FAILURE;
        }

        if (!$linkId) {
            $this->error('Missing link, use --link to target a link ID');
            return Command::FAILURE;
        }

        $link = Link::find($linkId);
        if (!$link) {
            $this->error('Link not found');
            return Command::FAILURE;
        }

        $review = new Review(['content' => $content]);
        $review->link()->associate($link);
        $review->save();

        $this->info("Review added [{$review->id}] to Link [{$link->id}] {$link->url}");
        return Command::SUCCESS;
    }
}
