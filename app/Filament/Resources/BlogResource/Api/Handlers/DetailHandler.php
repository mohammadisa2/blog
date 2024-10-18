<?php

namespace App\Filament\Resources\BlogResource\Api\Handlers;

use App\Filament\Resources\BlogResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{slug}';
    public static string | null $resource = BlogResource::class;
    public static bool $public = true;


    public function handler(Request $request)
    {
        $slug = $request->route('slug');
        
        $query = static::getEloquentQuery();

        $model = static::getModel();

        $query = QueryBuilder::for(
            $query->where('slug', $slug)
        )->allowedIncludes($model::getAllowedIncludes() ?? [])
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        $transformer = static::getApiTransformer();

        return new $transformer($query);
    }
}
