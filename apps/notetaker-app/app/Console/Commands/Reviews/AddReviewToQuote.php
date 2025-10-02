<?php

namespace App\Console\Commands\Reviews;

use App\Models\Quote;
use App\Models\Review;
use Illuminate\Console\Command;

class AddReviewToQuote extends Command
{
    protected $signature = 'quotes:review {quoteId} {review}';

    protected $description = 'Add a review to a quote (polymorphic)';

    public function handle(): int
    {
        $quoteId = (int)$this->argument('quoteId');
        $content = (string)$this->argument('review');

        if (trim($content) === '') {
            $this->error('Review content cannot be empty');
            return Command::FAILURE;
        }

        $quote = Quote::find($quoteId);
        if (!$quote) {
            $this->error('Quote not found.');
            return Command::FAILURE;
        }

        $review = new Review(['content' => $content]);
        $review->reviewable()->associate($quote);
        $review->save();

        $this->info("The review [{$review->id}] \"{$content}\" has been added to the quote {$quote->content}");
        return Command::SUCCESS;
    }
}
