<?php
namespace App\Filament\Resources\CategoryBlogResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\CategoryBlogResource;
use Illuminate\Routing\Router;


class CategoryBlogApiService extends ApiService
{
    protected static string | null $resource = CategoryBlogResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\PaginationHandler::class,
        ];

    }
}
