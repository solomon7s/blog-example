<?php


namespace App\Repositories;


use App\Enums\Pagination;
use App\Models\Blog\Post;
use App\QueryFilters\Author;
use App\QueryFilters\IsFeatured;
use App\QueryFilters\Sort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;


class PostRepository extends BaseRepository
{

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getFilteredPosts(): LengthAwarePaginator
    {
        $queryBuilder = $this->createQueryBuilder(
            with: ['createdBy'],
            withCount: ['comments']
        );
        $queryBuilder = app(Pipeline::class)
            ->send($queryBuilder)
            ->through([
                IsFeatured::class,
                Author::class,
                Sort::class
            ])->thenReturn();
        return $queryBuilder->paginate(Pagination::DEFAULT_PAGE_COUNT);
    }


}
