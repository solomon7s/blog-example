<?php

namespace Tests\Feature\BlogTests;

use App\Models\Account\User;
use App\Models\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeletePostsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Authenticated user can delete own post by id
     *
     * @return void
     */
    public function test_can_delete_post_if_authenticated(): void
    {

        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $this->deleteJson(route('posts.delete', ['id' => $post->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAll([
                    'message' => 'Post Deleted Successfully!',
                    'success' => true,
                ])
            );
    }

    /**
     * Authenticated user can't delete post if not exists
     *
     * @return void
     */
    public function test_cannot_delete_post_because_not_exists(): void
    {
        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $this->deleteJson(route('posts.delete', ['id' => Str::uuid()]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')->etc()
            );
    }

    /**
     * Authenticated user can't update post for different user
     *
     * @return void
     */
    public function test_cannot_delete_post_because_not_owner(): void
    {
        $post = $this->getPost();
        $this->authenticateUser();

        $this->deleteJson(route('posts.delete', ['id' => $post->id]))
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
    public function test_cannot_delete_post_if_not_authenticated(): void
    {
        $post = $this->getPost();
        $this->deleteJson(route('posts.delete', ['id' => $post->id]))
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','Unauthenticated.')
            );
    }


    private function getPost(?User $user = null): Post
    {
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Another Author',
                'email' => 'another.author@taskapp.com'
            ]);
        }
        return Post::factory()
            ->for($user, 'createdBy')
            ->create([
                'title'   => 'Amazing new Post',
                'content' => 'super great post content to read while smiling :D',
            ]);
    }

    private function authenticateUser(): User
    {
        $user = User::factory()->create([
            'name' => 'The Author',
            'email' => 'author@taskapp.com'
        ]);
        Sanctum::actingAs($user);
        return $user;
    }

}
