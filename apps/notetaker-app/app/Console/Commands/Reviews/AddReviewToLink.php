<?php

namespace App\Console\Commands\Reviews;

use App\Models\Link;
use App\Models\Review;
use Illuminate\Console\Command;

class AddReviewToLink extends Command
{
    protected $signature = 'links:review {linkId} {review}';

    protected $description = 'Add a review to a link (polymorphic)';

    public function handle(): int
    {
        $linkId = (int)$this->argument('linkId');
        $content = (string)$this->argument('review');

        if (trim($content) === '') {
            $this->error('Review content cannot be empty.');
            return Command::FAILURE;
        }

        $link = Link::find($linkId);
        if (!$link) {
            $this->error('Link not found.');
            return Command::FAILURE;
        }

        $review = new Review(['content' => $content]);
        $review->reviewable()->associate($link);
        $review->save();

        $target = $link->title ?: (string)$link->url;
        $this->info("A new review [$review->id] has been added to the link [$link->id].");
        return Command::SUCCESS;
    }
}
