<?php


namespace App\Services\Blog;


use App\DataTransferObjects\Blog\PostDTO;
use App\DataTransferObjects\Blog\PostPaginationDTO;
use App\DataTransferObjects\UpdateResponseDTO;
use App\Models\Blog\Post;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class PostService
{

    public function __construct(
        private PostRepository $postRepo
    ) {}


    public function getPostsList(): PostPaginationDTO
    {
        $paginatedPosts = $this->postRepo->getFilteredPosts();
        return PostPaginationDTO::createFromPagination($paginatedPosts);
    }

    public function addPost(array $data): PostDTO
    {
        $post = $this->postRepo->create($data);
        return PostDTO::createFromModel($post);
    }


    public function updatePost(string $id, array $data): PostDTO
    {
        $post = $this->postRepo->find($id);
        Gate::authorize('update', $post);
        $post = $this->postRepo->update($post, $data);
        return PostDTO::createFromModel($post);
    }

    public function deletePost(string $id): UpdateResponseDTO
    {
        $post = $this->postRepo->find($id);
        Gate::authorize('delete', $post);

        $isDeleted = $this->postRepo->delete($id);
        $message = $isDeleted ? 'Post Deleted Successfully!' : 'Failed to delete post, please try again!';
        return UpdateResponseDTO::create(
            message: $message,
            success: $isDeleted
        );
    }
}
