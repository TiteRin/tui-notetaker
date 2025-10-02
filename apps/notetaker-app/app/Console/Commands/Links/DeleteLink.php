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
    protected $signature = 'links:delete {idOrSlug}';

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
        $identifier = (string) $this->argument('idOrSlug');
        $link = Link::findByIdOrSlug($identifier);

        if (!$link) {
            $this->error("Link not found.");
            return Command::FAILURE;
        }

        // Guard: cannot delete if it has direct reviews or reviews on its quotes
        $hasDirect = $link->reviews()->exists();
        $quoteIds = $link->quotes()->pluck('id');
        $hasQuoteReviews = \App\Models\Review::where('reviewable_type', \App\Models\Quote::class)
            ->whereIn('reviewable_id', $quoteIds)->exists();
        if ($hasDirect || $hasQuoteReviews) {
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
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }

        $this->info("Link deleted.");
        return Command::SUCCESS;
    }
}
