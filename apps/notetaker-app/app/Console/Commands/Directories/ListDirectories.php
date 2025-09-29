<?php

namespace App\Console\Commands\Directories;

use Illuminate\Console\Command;

class ListDirectories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'directories:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the directories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("No directory found.");
        return Command::SUCCESS;
    }
}
