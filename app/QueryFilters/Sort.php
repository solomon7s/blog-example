<?php


namespace App\QueryFilters;


use Illuminate\Database\Eloquent\Builder;

class Sort extends Filter
{
    const ALLOWED_VALUES = ['created_at', 'title', 'is_featured'];

    protected function applyFilter(Builder $builder): Builder
    {
        $sort = $this->getFilterValue();
        if (!in_array($sort, self::ALLOWED_VALUES)) {
            $sort = 'created_at';
        }
        $direction = request()->query('dir', 'DESC');
        if ($direction === 'ASC') {
            return $builder->orderBy($sort);
        }
        return $builder->orderByDesc($sort);
    }
}
