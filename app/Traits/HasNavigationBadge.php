<?php

namespace App\Traits;

trait HasNavigationBadge
{
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()
            ->when(method_exists(static::class, 'getNavigationBadgeQuery'), function ($query) {
                return static::getNavigationBadgeQuery($query);
            })
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
} 