<?php
namespace App\Console\Commands\Links;

use App\Models\Link;
use Illuminate\Console\Command;
use function Laravel\Prompts\confirm;

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
        $link = Link::find($id);

        if (!$link) {
            $this->error("Link not found.");
            return Command::FAILURE;
        }

        if ($link->reviews()->exists()) {
            $this->error('Cannot delete a link that has reviews.');
            return Command::FAILURE;
        }

        $confirmation = confirm("You’re about to delete the link $link->url. Are you sure you want to delete it? [Y/n]");

        if (!$confirmation) {
            $this->info("Deletion canceled.");
            return Command::SUCCESS;
        }

        try {
            $link->delete();
            $this->info("Link deleted.");
            return Command::SUCCESS;
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
