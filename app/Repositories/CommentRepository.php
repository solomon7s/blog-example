<?php


namespace App\Repositories;


use App\Enums\Pagination;
use App\Models\Blog\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CommentRepository extends BaseRepository
{

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }



    public function getCommentsByPost(string $postId): LengthAwarePaginator
    {
        return $this->createQueryBuilder(
                with: ['createdBy']
            )
            ->where('post_id', $postId)
            ->latest()
            ->paginate(Pagination::DEFAULT_PAGE_COUNT);
    }


}
