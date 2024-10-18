<?php
namespace App\Filament\Resources\CategoryBlogResource\Api\Handlers;

use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\CategoryBlogResource;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = CategoryBlogResource::class;
    public static bool $public = true;

    public function handler()
    {
        $query = static::getEloquentQuery();
        $model = static::getModel();

        $query = QueryBuilder::for($query)
        ->paginate(request()->query('per_page'))
        ->appends(request()->query());

        return static::getApiTransformer()::collection($query);
    }
}
