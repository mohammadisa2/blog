<?php
namespace App\Filament\Resources\BlogResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\BlogResource;
use Illuminate\Routing\Router;


class BlogApiService extends ApiService
{
    protected static string | null $resource = BlogResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
