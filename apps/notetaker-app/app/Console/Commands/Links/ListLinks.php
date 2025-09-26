<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a links list';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Listing links");

        $links = Link::all();

        if ($links->isEmpty()) {
            $this->info("No links found");
            return Command::SUCCESS;
        }

        $linkStr = Str::plural('link', $links->count());
        $this->info("{$links->count()} $linkStr found");

        $this->table(
            ['ID', 'Url'],
            $links->map(function ($link) {
                return [$link->id, $link->url];
            })
        );
        return Command::SUCCESS;
    }
}
