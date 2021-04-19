<?php


namespace App\Services\Blog;


use App\DataTransferObjects\Blog\CommentDTO;
use App\DataTransferObjects\Blog\CommentPaginationDTO;
use App\DataTransferObjects\Blog\PostDTO;
use App\DataTransferObjects\UpdateResponseDTO;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class CommentService
{

    public function __construct(
        private CommentRepository $commentRepo,
        private PostRepository    $postRepo
    ) {}


    /**
     * @param string $postId
     * @return CommentPaginationDTO
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getPostComments(string $postId): CommentPaginationDTO
    {
        $paginatedList = $this->commentRepo->getCommentsByPost($postId);
        return CommentPaginationDTO::createFromPagination($paginatedList);
    }


    public function addComment(string $postId, array $data): CommentDTO
    {
        $post = $this->postRepo->find($postId);
        $data['post_id'] = $post->id;
        $comment = $this->commentRepo->create($data);
        return CommentDTO::createFromModel($comment);
    }


    public function updateComment(string $id, array $data): CommentDTO
    {
        $comment = $this->commentRepo->find($id);
        Gate::authorize('update', $comment);
        $comment = $this->commentRepo->update($comment, $data);
        return CommentDTO::createFromModel($comment);
    }

    public function deleteComment(string $id): UpdateResponseDTO
    {
        $comment = $this->commentRepo->find($id);

        Gate::authorize('delete', $comment);

        $isDeleted = $this->commentRepo->delete($id);
        $message = $isDeleted ? 'Comment Deleted Successfully!' : 'Failed to delete Comment, please try again!';
        return UpdateResponseDTO::create(
            message: $message,
            success: $isDeleted
        );
    }
}
