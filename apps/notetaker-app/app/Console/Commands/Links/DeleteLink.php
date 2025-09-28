<?php

namespace App\Console\Commands\Links;

use Illuminate\Console\Command;

class DeleteLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a link';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $id = $this->argument('id');

        $this->error("Link not found.");
        return Command::FAILURE;
    }
}
