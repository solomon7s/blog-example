<?php

namespace Tests\Feature\BlogTests;

use App\Models\Account\User;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCommentsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Authenticated user can delete own comment by id
     *
     * @return void
     */
    public function test_can_delete_comment_if_authenticated(): void
    {

        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $comment = $this->getComment(
            post: $post,
            user: $user
        );
        $this->deleteJson(route('posts.comments.delete', ['id' => $post->id, 'cid' => $comment->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAll([
                    'message' => 'Comment Deleted Successfully!',
                    'success' => true,
                ])
            );
    }

    /**
     * Authenticated user can't delete comment if not exists
     *
     * @return void
     */
    public function test_cannot_delete_comment_because_not_exists(): void
    {
        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $comment = $this->getComment(
            post: $post,
            user: $user
        );
        $this->deleteJson(route('posts.comments.delete', ['id' => $post->id, 'cid' => Str::uuid()]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')
                    ->etc()
            );
    }

    /**
     * Authenticated user can't update comment for different user
     *
     * @return void
     */
    public function test_cannot_delete_comment_because_not_owner(): void
    {
        $post = $this->getPost();
        $comment = $this->getComment(
            post: $post
        );
        $this->authenticateUser();

        $this->deleteJson(route('posts.comments.delete', ['id' => $post->id, 'cid' => $comment->id ]))
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')->etc()
            );
    }

    /**
     * Unauthenticated user can't delete post
     *
     * @return void
     */
    public function test_cannot_delete_comment_if_not_authenticated(): void
    {
        $post = $this->getPost();
        $comment = $this->getComment(
            post: $post
        );
        $this->deleteJson(route('posts.comments.delete', ['id' => $post->id, 'cid' => $comment->id ]))
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','Unauthenticated.')
            );
    }



    private function getComment(Post $post, ?User $user = null): Comment
    {
        if (!$user) {
            $user = User::factory()->create();
        }
        return Comment::factory()
            ->for($post, 'post')
            ->for($user, 'createdBy')
            ->create([
                'body' => 'Amazing comment for amazing post!'
            ]);
    }

    private function getPost(?User $user = null): Post
    {
        if (!$user) {
            $user = User::factory()->create();
        }
        return Post::factory()
            ->for($user, 'createdBy')
            ->create([
                'title'   => 'Amazing new Post',
                'content' => 'super great comment content to read while smiling :D',
            ]);
    }

    private function authenticateUser(): User
    {
        $user = User::factory()->create(['name' => 'The Author']);
        Sanctum::actingAs($user);
        return $user;
    }


}
