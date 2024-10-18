<?php
namespace App\Filament\Resources\BlogResource\Api\Handlers;

use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\BlogResource;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = BlogResource::class;
    public static bool $public = true;


    public function handler()
    {
        $query = static::getEloquentQuery();
        $model = static::getModel();

        $query = QueryBuilder::for($query)
        ->allowedSorts($model::getAllowedSorts() ?? [])
        ->allowedFilters($model::getAllowedFilters() ?? [])
        ->allowedIncludes($model::getAllowedIncludes() ?? [])
        ->paginate(10)
        ->appends(request()->query());

        return static::getApiTransformer()::collection($query);
    }
}
