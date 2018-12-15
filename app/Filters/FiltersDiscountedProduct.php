<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersDiscountedProduct implements Filter
{

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return ($value) ? $query->whereHas('discounts') : $query->whereDoesntHave('discounts');
    }
}
