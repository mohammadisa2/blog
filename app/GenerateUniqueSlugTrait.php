<?php

declare(strict_types=1);

namespace App;

trait GenerateUniqueSlugTrait
{
    public static function bootGenerateUniqueSlugTrait(): void
    {
        static::saving(function ($model) {
            $slug = $model->slug;
            $model->slug = $model->generateUniqueSlug($slug);
        });
    }

    public function generateUniqueSlug($slug): string
    {
        $counter = 1;

        $baseSlug = $slug;

        while ($this->where('slug', $slug)->where('id', '!=', $this->id ?? null)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
