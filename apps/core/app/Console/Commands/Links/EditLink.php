<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use Illuminate\Console\Command;

class EditLink extends Command
{
    protected $signature = 'links:edit {idOrSlug} {--T|set-title=} {--U|set-url=}';

    protected $description = 'Edit a link';

    public function handle(): int
    {
        $idOrSlug = $this->argument("idOrSlug");
        $setTitle = $this->option("set-title");
        $setUrl   = $this->option('set-url');
        $link = Link::findByIdOrSlug($idOrSlug);

        if(!$link) {
            $this->error("No Link found with this identifier [$idOrSlug].");
            return Command::SUCCESS;
        }

        if (!($setTitle || $setUrl)) {
            $this->error("No options provided, use --set-title or --set-url. Edition canceled.");
            return Command::SUCCESS;
        }

        if ($setUrl) {
            $link->url = $setUrl;

            if (!$setTitle) {
                $setTitle = Link::fetchTitleFromUrl($setUrl);
            }
        }

        if ($setTitle) {
            $link->title = $setTitle;
        }

        $link->save();

        $this->info("Link [$link->id] edited : $link->url ($link->title)");
        return Command::SUCCESS;
    }

}
