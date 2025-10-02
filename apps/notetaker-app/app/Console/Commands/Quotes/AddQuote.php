<?php

namespace App\Console\Commands\Quotes;

use App\Models\Link;
use App\Models\Quote;
use Illuminate\Console\Command;

class AddQuote extends Command
{
    protected $signature = 'links:quote {linkId} {quote} {--author=}';

    protected $description = 'Add a quote to a link';

    public function handle(): int
    {
        $linkId = (int)$this->argument('linkId');
        $content = (string)$this->argument('quote');
        $author = $this->option('author');

        if (trim($content) === '') {
            $this->error('Quote content cannot be empty');
            return Command::FAILURE;
        }

        $link = Link::find($linkId);
        if (!$link) {
            $this->error('Link not found.');
            return Command::FAILURE;
        }

        $quote = new Quote(['content' => $content, 'author' => $author]);
        $quote->link()->associate($link);
        $quote->save();

        $target = $link->title ?: (string)$link->url;
        $this->info("The quote [{$quote->id}] \"{$content}\" has been added to {$target}");
        return Command::SUCCESS;
    }
}
