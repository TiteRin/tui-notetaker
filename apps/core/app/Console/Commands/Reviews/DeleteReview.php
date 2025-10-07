<?php

namespace App\Console\Commands\Reviews;

use App\Models\Review;
use Illuminate\Console\Command;

class DeleteReview extends Command
{
    protected $signature = 'reviews:delete {reviewId}';

    protected $description = 'Delete a review';

    public function handle(): int
    {
        $id = (int) $this->argument('reviewId');
        $review = Review::find($id);
        if (!$review) {
            $this->error('Review not found.');
            return Command::FAILURE;
        }

        $review->delete();
        $this->info("Review [$id] deleted");
        return Command::SUCCESS;
    }
}
