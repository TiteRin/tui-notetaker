<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use Illuminate\Console\Command;

class ListLinkReviews extends Command
{
    protected $signature = 'links:reviews {idOrSlug}';

    protected $description = 'List reviews for a link';

    public function handle(): int
    {
        $link = Link::findByIdOrSlug((string)$this->argument('idOrSlug'));
        if (!$link) {
            $this->error('Link not found.');
            return Command::FAILURE;
        }

        $reviews = $link->reviews()->get(['id','content']);
        if ($reviews->isEmpty()) {
            $this->info("No reviews found for link [{$link->id}] {$link->url}");
            return Command::SUCCESS;
        }

        $this->table(['ID','Content'], $reviews->map(fn($r) => [(string)$r->id, $r->content]));
        return Command::SUCCESS;
    }
}
