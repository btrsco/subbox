<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use function Pest\Laravel\get;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory,
        SoftDeletes,
        HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'user_id',
            'blog_id',
            'title',
            'slug',
            'subtitle',
            'content',
            'published_at',
        ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string> $appends
     */
    protected $appends
        = [
            'status',
        ];

    /* Relationships
     * - - - - - - - - - - - - - */

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* Accessors & Mutators
     * - - - - - - - - - - - - - */

    public function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->published_at === null) {
                    return 'draft';
                }

                if ($this->published_at->isFuture()) {
                    return 'scheduled';
                }

                if ($this->trashed()) {
                    return 'archived';
                }

                return 'published';
            }
        );
    }

    /* Scopes
     * - - - - - - - - - - - - - */

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDrafts($query)
    {
        return $query->whereNull('published_at');
    }

    public function scopeScheduled($query)
    {
        return $query->where('published_at', '>', now());
    }

    public function scopeArchived($query)
    {
        return $query->onlyTrashed();
    }

    /* Spatie\Sluggable
     * - - - - - - - - - - - - - */

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->extraScope(fn ($builder) => $builder->where('blog_id', $this->blog_id));
    }
}
