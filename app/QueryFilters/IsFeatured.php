<?php


namespace App\QueryFilters;


use Illuminate\Database\Eloquent\Builder;

class IsFeatured extends Filter
{

    protected function applyFilter(Builder $builder): Builder
    {
        return $builder->where(
            $this->filterName(),
            (boolean) json_decode(strtolower($this->getFilterValue()))
        );

    }
}
