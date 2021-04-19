<?php


namespace App\QueryFilters;


use Illuminate\Database\Eloquent\Builder;

class Author extends Filter
{

    protected function applyFilter(Builder $builder): Builder
    {
        return $builder->where('created_by', $this->getFilterValue());
    }
}
