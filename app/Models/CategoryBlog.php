<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryBlog extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_blog_id');
    }
}
