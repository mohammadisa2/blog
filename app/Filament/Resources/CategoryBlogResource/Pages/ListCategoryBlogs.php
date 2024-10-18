<?php

namespace App\Filament\Resources\CategoryBlogResource\Pages;

use App\Filament\Resources\CategoryBlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryBlogs extends ListRecords
{
    protected static string $resource = CategoryBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
