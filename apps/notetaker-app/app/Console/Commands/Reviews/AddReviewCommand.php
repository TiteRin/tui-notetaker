<?php

namespace App\Console\Commands\Reviews;

use App\Models\Link;
use App\Models\Quote;
use App\Models\Review;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class AddReviewCommand extends Command
{

    abstract public function getReviewAssociate(): Link|Quote|null;

    abstract public function getReviewAssociateType(): string;

    public function handle(): int
    {
        $content = (string)$this->argument('review');

        if (trim($content) === '') {
            $this->error('Review content cannot be empty.');
            return Command::FAILURE;
        }

        $associate = $this->getReviewAssociate();
        $associateType = $this->getReviewAssociateType();

        if (!$associate) {
            $this->error(ucfirst("$associateType not found."));
            return Command::FAILURE;
        }

        $review = new Review(['content' => $content]);
        $review->reviewable()->associate($associate);
        $review->save();

        $this->info("A new review [$review->id] has been added to the $associateType [$associate->id].");
        return Command::SUCCESS;
    }
}
