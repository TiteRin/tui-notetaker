<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use App\Casts\UrlCast;
use Database\Factories\LinkFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

#[ApiResource]
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = ['url', 'title', 'directory_id'];

    protected $casts = [
        'url' => UrlCast::class,
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($instance) {
            if (!$instance->title) {
                $instance->title = self::fetchTitleFromUrl((string)$instance->url);
                $instance->slug = self::generateUniqueSlug($instance->title);
            }

            if (!$instance->slug) {
                $instance->slug = self::generateUniqueSlug($instance->title);
            }
        });
    }

    public function quotesReviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Quote::class,
            'link_id',
            'reviewable_id',
            'id',
            'id'
        )->where('reviewable_type', Quote::class);
    }

    public function scopeWithReviewsCount($query)
    {
        return $query
            ->withCount('reviews')
            ->withCount('quotes')
            ->withCount('quotesReviews');

    }

    public function getTotalReviewsCountAttribute()
    {
        return ($this->reviews_count ?? 0) + ($this->quotes_reviews_count ?? 0);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function directory(): BelongsTo
    {
        return $this->belongsTo(Directory::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public static function findByIdOrSlug(string $identifier): ?self
    {
        if (ctype_digit($identifier)) {
            return static::find((int)$identifier);
        }
        return static::where('slug', $identifier)->first();
    }

    public static function generateUniqueSlug(?string $title): ?string
    {
        if (!$title) return null;
        $base = Str::slug($title);
        if ($base === '') return null;
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }

    public static function fetchTitleFromUrl(string $url): ?string
    {
        try {
            $response = file_get_contents($url);
            $matches = [];
            if (!preg_match('/<title>(.*?)<\/title>/', $response, $matches)) {
                return null;
            }
            return $matches[1];
        } catch (Exception $e) {
            return null;
        }
    }
}
