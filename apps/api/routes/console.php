<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Link;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Create a new link
// Usage examples:
//  php artisan links:create --url="https://example.com"
Artisan::command('links:create {--url= : The URL for the new link}', function () {
    $url = (string) $this->option('url');

    if (empty($url)) {
        $this->error('The --url option is required.');
        return 1;
    }

    // Basic URL validation
    if (! filter_var($url, FILTER_VALIDATE_URL)) {
        $this->error('Invalid URL format.');
        return 1;
    }

    $link = new Link();
    $link->url = $url;
    $link->save();

    $this->info('Link created successfully.');
    $this->line('ID:   ' . $link->id);
    $this->line('URL:  ' . $link->url);
    $this->line('When: ' . $link->created_at);

    return 0;
})->purpose('Create a new link');

// Read links
// Usage examples:
//  php artisan links:read                 # list all
//  php artisan links:read --id=5          # show one by id
Artisan::command('links:read {--id= : The ID of the link to read (optional)}', function () {
    $id = $this->option('id');

    if ($id !== null && $id !== '') {
        $link = Link::query()->find($id);
        if (! $link) {
            $this->error("Link with id {$id} not found.");
            return 1;
        }
        $this->info('Link');
        $this->line('ID:   ' . $link->id);
        $this->line('URL:  ' . $link->url);
        $this->line('When: ' . $link->created_at);
        return 0;
    }

    $links = Link::query()->orderByDesc('id')->get(['id','url','created_at']);
    if ($links->isEmpty()) {
        $this->warn('No links found.');
        return 0;
    }

    foreach ($links as $link) {
        $this->line(sprintf('[%d] %s (created %s)', $link->id, $link->url, $link->created_at));
    }

    return 0;
})->purpose('Read one or many links');

// Edit a link
// Usage examples:
//  php artisan links:edit --id=5 --url="https://new.example.com"
Artisan::command('links:edit {--id= : The ID of the link to edit} {--url= : New URL}', function () {
    $id = $this->option('id');
    $url = $this->option('url');

    if (empty($id)) {
        $this->error('The --id option is required.');
        return 1;
    }
    if (empty($url)) {
        $this->error('The --url option is required.');
        return 1;
    }
    if (! filter_var($url, FILTER_VALIDATE_URL)) {
        $this->error('Invalid URL format.');
        return 1;
    }

    $link = Link::query()->find($id);
    if (! $link) {
        $this->error("Link with id {$id} not found.");
        return 1;
    }

    $link->url = $url;
    $link->save();

    $this->info('Link updated successfully.');
    $this->line('ID:   ' . $link->id);
    $this->line('URL:  ' . $link->url);
    $this->line('When: ' . $link->updated_at);

    return 0;
})->purpose('Edit a link by id');

// Delete a link
// Usage examples:
//  php artisan links:delete --id=5
Artisan::command('links:delete {--id= : The ID of the link to delete}', function () {
    $id = $this->option('id');

    if (empty($id)) {
        $this->error('The --id option is required.');
        return 1;
    }

    $link = Link::query()->find($id);
    if (! $link) {
        $this->error("Link with id {$id} not found.");
        return 1;
    }

    $url = $link->url;
    $link->delete();

    $this->info("Link {$id} deleted.");
    $this->line('URL: ' . $url);

    return 0;
})->purpose('Delete a link by id');
