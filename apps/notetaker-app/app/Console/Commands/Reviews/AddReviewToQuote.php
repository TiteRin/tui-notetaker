<?php

namespace App\Console\Commands\Reviews;

use App\Models\Quote;

class AddReviewToQuote extends AddReviewCommand
{
    protected $signature = 'quotes:review {quoteId} {review}';

    protected $description = 'Add a review to a quote (polymorphic)';

    public function getReviewAssociate(): ?Quote
    {
        $quoteId = $this->argument('quoteId');
        return Quote::find($quoteId);
    }

    public function getReviewAssociateType(): string
    {
        return "quote";
    }
}
