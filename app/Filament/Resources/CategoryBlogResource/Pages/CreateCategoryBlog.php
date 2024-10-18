<?php

namespace App\Filament\Resources\CategoryBlogResource\Pages;

use App\Filament\Resources\CategoryBlogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryBlog extends CreateRecord
{
    protected static string $resource = CategoryBlogResource::class;
}
