<?php

namespace App\Models;

use App\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rupadana\ApiService\Contracts\HasAllowedSorts;
use Rupadana\ApiService\Contracts\HasAllowedFilters;
use Rupadana\ApiService\Contracts\HasAllowedIncludes;

class Blog extends Model implements HasAllowedSorts, HasAllowedFilters, HasAllowedIncludes
{
    use GenerateUniqueSlugTrait;
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'tags',
        'category_blog_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryBlog::class, 'category_blog_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function scopeHasTag(Builder $query, string $tag): Builder
    {
        return $query->where('tags', 'like', "%\"{$tag}\"%");
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ?? [];
    }

    public static function getAllowedSorts(): array
    {
        return [
            'id'
        ];
    }

    public static function getAllowedFilters(): array
    {
        return [
            'title',
            'tags',
            'category.slug'
        ];
    }

    public static function getAllowedIncludes(): array
    {
        return [
            'category'
        ];
    }
}
