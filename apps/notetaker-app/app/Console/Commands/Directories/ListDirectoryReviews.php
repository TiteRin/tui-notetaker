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

        $links = $directory->links()->with('reviews:id,content,link_id')->get();

        foreach ($links as $link) {
            $count = $link->reviews->count();
            $label = Str::plural('review', $count, prependCount: true);
            $this->info("Link [{$link->id}] {$link->url} - $label");
            if ($count > 0) {
                $this->table(['ID','Content'], $link->reviews->map(fn($r) => [(string)$r->id, $r->content]));
            }
        }

        return Command::SUCCESS;
    }
}
