<?php

namespace App\Console\Commands\Reviews;

use App\Models\Link;

class AddReviewToLink extends AddReviewCommand
{
    protected $signature = 'links:review {linkId} {review}';

    protected $description = 'Add a review to a link';


    public function getReviewAssociate(): ?Link
    {
        $linkId = $this->argument('linkId');
        return Link::findByIdOrSlug($linkId);
    }

    public function getReviewAssociateType(): string
    {
        return "link";
    }
}
