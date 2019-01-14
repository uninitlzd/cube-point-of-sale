<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersDiscountIdOrNull implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->where('discount_id', $value)->orWhereNull('discount_id');
    }
}
