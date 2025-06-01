<?php

namespace App\Traits;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

trait HasOptimizedResource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Eager loading relationships
        if (method_exists(static::class, 'getRelations')) {
            $query->with(static::getRelations());
        }

        // Apply global scopes
        if (method_exists(static::class, 'getGlobalScopes')) {
            foreach (static::getGlobalScopes() as $scope) {
                $query->withGlobalScope($scope['name'], $scope['scope']);
            }
        }

        return $query;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->lazy()
            ->defaultPaginationPageOption(25)
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession();
    }

    protected static function getRelations(): array
    {
        return [];
    }

    public static function getCachedCount(string $key, \Closure $callback, int $ttl = 3600): int
    {
        return Cache::remember("count:{$key}", $ttl, $callback);
    }

    public static function getCachedQuery(string $key, \Closure $callback, int $ttl = 3600)
    {
        return Cache::remember("query:{$key}", $ttl, $callback);
    }

    public static function clearCache(string $key): void
    {
        Cache::forget("count:{$key}");
        Cache::forget("query:{$key}");
    }
} 