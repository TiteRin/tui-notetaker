<?php

namespace App\Console\Commands\Links;

use App\Models\Link;
use App\ValueObjects\Url;
use Exception;
use Illuminate\Console\Command;

class AddLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:add {url} {--D|directory=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new link';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $url = new Url($this->argument('url'));
            $directory = $this->option('directory');

            if (!$directory) {
                $this->error("Missing directory, use -D or --directory to assign the link to a directory.");
                return Command::FAILURE;
            }

            $link = Link::create(['url' => $url]);
        }
        catch(Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        $this->info("Link added [$link->id] $link->url");
        return Command::SUCCESS;
    }
}
