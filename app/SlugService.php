<?php

namespace App;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class SlugService {
    static function generate($model, Get $get, Set $set, ?string $old, ?string $state) {
        if (empty($state)) {
            return;
        }

        if (($get('slug') ?? '') === Str::slug($old)) {
            $slug = $model->generateUniqueSlug(Str::slug($state));
            $set('slug', $slug);
        }
    }
}
