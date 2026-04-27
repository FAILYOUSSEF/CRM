<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Trait for adding faceted filtering capabilities to controllers
 * Provides methods for building queryable filters with multiple facets
 */
trait Filterable
{
    /**
     * Apply text search to query
     */
    protected function applySearch(Builder $query, Request $request, array $searchFields): Builder
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            return $query->where(function ($q) use ($search, $searchFields) {
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }
        return $query;
    }

    /**
     * Apply exact match filters
     */
    protected function applyExactFilters(Builder $query, Request $request, array $filterFields): Builder
    {
        foreach ($filterFields as $field) {
            if ($request->filled($field)) {
                $value = $request->input($field);
                // Handle multiple values (array)
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }
        return $query;
    }

    /**
     * Apply date range filters
     */
    protected function applyDateRangeFilters(Builder $query, Request $request, array $dateFields): Builder
    {
        foreach ($dateFields as $field) {
            $fromKey = $field . '_from';
            $toKey = $field . '_to';
            
            if ($request->filled($fromKey)) {
                $query->whereDate($field, '>=', $request->input($fromKey));
            }
            
            if ($request->filled($toKey)) {
                $query->whereDate($field, '<=', $request->input($toKey));
            }
        }
        return $query;
    }

    /**
     * Get filter options for faceted search
     */
    protected function getFilterOptions(string $field, string $model): array
    {
        $modelClass = "App\\Models\\{$model}";
        return $modelClass::distinct()
            ->where($field, '!=', null)
            ->pluck($field)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Get related model options for filters
     */
    protected function getRelatedOptions(string $relation, string $field = 'id'): array
    {
        // This will be customized per controller
        return [];
    }
}
