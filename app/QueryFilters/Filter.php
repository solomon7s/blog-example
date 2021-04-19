<?php


namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Filter
{

    public function handle($request, Closure $next): Builder
    {
        if (!$this->getFilterValue()) {
            return $next($request);
        }

        $builder = $next($request);

        return $this->applyFilter($builder);


    }

    protected abstract function applyFilter(Builder $builder): Builder;


    protected function getFilterValue(): ?string
    {
        $defaultValue = $this->filterName() === 'sort' ? 'created_at': null;
        return request()->query($this->filterName(), $defaultValue);
    }

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }
}
