<?php

namespace App\Console\Commands\Directories;

use App\Models\Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListDirectoryReviews extends Command
{
    protected $signature = 'directory:reviews {directoryId}';

    protected $description = 'List reviews for a directory grouped by link';

    public function handle(): int
    {
        $directory = Directory::find($this->argument('directoryId'));
        if (!$directory) {
            $this->error('Directory not found.');
            return Command::FAILURE;
        }

        $this->info("Directory [{$directory->id}] {$directory->getIconAndName()}");

        $links = $directory->links()->with(['reviews:id,content,reviewable_id,reviewable_type', 'quotes.reviews:id,content,reviewable_id,reviewable_type'])->get();

        foreach ($links as $link) {
            $directCount = $link->reviews->count();
            $quoteReviewCount = optional($link->quotes)->reduce(function($carry, $q){ return $carry + $q->reviews->count(); }, 0);
            $total = $directCount + $quoteReviewCount;
            $label = Str::plural('review', $total, prependCount: true);
            $this->info("Link [{$link->id}] {$link->url} - $label");
            if ($directCount > 0) {
                $this->table(['ID','Content'], $link->reviews->map(fn($r) => [(string)$r->id, $r->content]));
            }
        }

        return Command::SUCCESS;
    }
}
