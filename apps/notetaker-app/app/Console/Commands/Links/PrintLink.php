<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PrintLink extends Command
{
    protected $signature = 'links:print {idOrSlug}';

    protected $description = 'Print the content of a link: header, then quotes and reviews in created order';

    public function handle(): int
    {
        $identifier = (string)$this->argument('idOrSlug');
        $link = Link::findByIdOrSlug($identifier);

        if (!$link) {
            $this->error('Link not found.');
            return Command::FAILURE;
        }

        $header = "[$link->id] $link->title ($link->url)";
        $this->line($header);
        $this->line(Str::repeat("=", Str::length($header)));
        $this->line("0 quote / 0 review");
        $this->line("  To add a quote : links:quote $link->id \"Your quote\" (--author=\"Author Name\")");
        $this->line("  To add a review : links:review $link->id \"Your review\"");
//
//        // Fetch top-level items (quotes and direct reviews) with created_at
//        $quotes = $link->quotes()->orderBy('created_at')->get();
//        $reviews = $link->reviews()->orderBy('created_at')->get();
//
//        // Merge and sort by created_at to interleave quotes and reviews
//        $items = collect();
//        foreach ($quotes as $q) {
//            $items->push([
//                'type' => 'quote',
//                'created_at' => $q->created_at,
//                'model' => $q,
//            ]);
//        }
//        foreach ($reviews as $r) {
//            $items->push([
//                'type' => 'review',
//                'created_at' => $r->created_at,
//                'model' => $r,
//            ]);
//        }
//
//        /** @var Collection $items */
//        $items = $items->sortBy('created_at')->values();
//
//        if ($items->isEmpty()) {
//            return Command::SUCCESS;
//        }
//
//        // Print a blank line between each top-level block
//        foreach ($items as $index => $item) {
//            // blank line before each block except the first
//            $this->line('');
//
//            if ($item['type'] === 'review') {
//                $this->line($item['model']->content);
//            } else { // quote
//                $quote = $item['model'];
//                $this->line('> ' . $quote->content);
//
//                // Print quote reviews (indented), ordered by created_at
//                $quoteReviews = $quote->reviews()->orderBy('created_at')->get();
//                foreach ($quoteReviews as $qr) {
//                    $this->line('  - ' . $qr->content);
//                }
//            }
//        }

        return Command::SUCCESS;
    }
}
