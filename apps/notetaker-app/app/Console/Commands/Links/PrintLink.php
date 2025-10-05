<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use App\Models\Quote;
use App\Models\Review;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PrintLink extends Command
{
    protected $signature = 'links:print {idOrSlug}';

    protected $description = 'Print the content of a link: header, then quotes and reviews in created order';

    public function handle(): int
    {
        $identifier = (string) $this->argument('idOrSlug');
        $link = Link::withReviewsCount()->findByIdOrSlug($identifier)->first();

        if (!$link) {
            $this->error('Link not found.');
            return Command::FAILURE;
        }

        $header = "[$link->id] $link->title ($link->url)";
        $this->line($header);
        $this->line(Str::repeat("=", Str::length($header)));

        $nbReviews = Str::plural("review", $link->total_reviews_count, true);
        $nbQuotes  = Str::plural("quote", $link->quotes_count, true);

        $this->line("$nbQuotes / $nbReviews");
        $this->line("  To add a quote : links:quote $link->id \"Your quote\" (--author=\"Author Name\")");
        $this->line("  To add a review : links:review $link->id \"Your review\"");
        $this->line('');
//
        // Fetch top-level items (quotes and direct reviews) with created_at
        $quotes = $link->quotes()->orderBy('created_at')->get();
        $reviews = $link->reviews()->orderBy('created_at')->get();

        $all = $quotes->concat($reviews)->sortBy('created_at');

        $all->each(function ($item) {

            if (get_class($item) == Quote::class) {
                $this->info("[Quote $item->id]");
                $this->line("> $item->content");

                $item->reviews->each(function ($review) {
                    $this->info("    [Review $review->id]");
                    $this->line("    - $review->content");
                });
            }

            if (get_class($item) == Review::class) {
                $this->info("[Review $item->id]");
                $this->line("# $item->content");
            }

            $this->line('');
        });

        return Command::SUCCESS;
    }
}
