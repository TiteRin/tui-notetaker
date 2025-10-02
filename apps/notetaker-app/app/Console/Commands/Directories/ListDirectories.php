<?php

namespace App\Console\Commands\Directories;

use App\Models\Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $directories = Directory::all();

        if ($directories->count() === 0) {
            $this->info("No directory found.");
            return Command::SUCCESS;
        }

        $count = $directories->count();
        $plural = Str::plural("directory", $count, prependCount: true);

        $this->info("$plural found.");
        $this->table(
            ["ID", "Name", "# Links"],
            $directories->map(function(Directory $directory) {
                return [
                    $directory->id,
                    $directory->name,
                    $directory->links()->count()
                ];
            })
        );
        return Command::SUCCESS;
    }
}
