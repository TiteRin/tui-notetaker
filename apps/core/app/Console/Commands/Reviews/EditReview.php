<?php

namespace App\Console\Commands\Reviews;

use App\Models\Review;
use Illuminate\Console\Command;

class EditReview extends Command
{
    protected $signature = 'reviews:edit {reviewId} {review}';

    protected $description = 'Edit a review';

    public function handle(): int
    {
        $id = (int) $this->argument('reviewId');
        $content = (string) $this->argument('review');

        $review = Review::find($id);
        if (!$review) {
            $this->error('Review not found.');
            return Command::FAILURE;
        }

        $review->content = $content;
        $review->save();

        $this->info("Review [$id] updated");
        return Command::SUCCESS;
    }
}
