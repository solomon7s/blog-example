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

class UpdatePostsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Authenticated user can update post with valid input data
     *
     * @return void
     */
    public function test_can_update_post_if_authenticated(): void
    {

        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $this->putJson(route('posts.update', ['id' => $post->id]), [
                'title'   => 'New Amazing new Post',
                'content' => 'This is the updated super great post content to read while smiling :D',
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'id'             => 'string',
                    'title'          => 'string',
                    'content'        => 'string',
                    'is_featured'    => 'boolean',
                    'comments_count' => 'integer',
                    'created_at'     => 'string',
                    'user'           => 'array'
                ])->where('user.name', $user->name)
            );
    }

    /**
     * Authenticated user can't update post with empty or invalid input data
     *
     * @return void
     */
    public function test_cannot_update_post_because_validation_error(): void
    {
        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $this->putJson(route('posts.update', ['id' => $post->id]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
            );
    }

    /**
     * Authenticated user can't update post if not exists
     *
     * @return void
     */
    public function test_cannot_update_post_because_not_exists(): void
    {
        $user = $this->authenticateUser();
        $post = $this->getPost($user);
        $this->putJson(route('posts.update', ['id' => Str::uuid()]), [
                'title'   => 'New Amazing new Post',
                'content' => 'This is the updated super great post content to read while smiling :D',
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')
                ->etc()
            );
    }


    /**
     * Authenticated user can't update post for different  user
     *
     * @return void
     */
    public function test_cannot_update_post_because_not_owner(): void
    {
        $post = $this->getPost();
        $this->authenticateUser();

        $this->putJson(route('posts.update', ['id' => $post->id]), [
                'title'   => 'New Amazing new Post',
                'content' => 'This is the updated super great post content to read while smiling :D',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message', 'string')->etc()
            );
    }

    /**
     * Unauthenticated user can't update post even if valid input data
     *
     * @return void
     */
    public function test_cannot_update_post_if_not_authenticated(): void
    {
        $post = $this->getPost();
        $this->putJson(route('posts.update', ['id' => $post->id]), [
                'title'   => 'Not Amazing new Post',
                'content' => 'Not Updated super great post content to read while smiling :D',
            ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','Unauthenticated.')
            );
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
                'content' => 'super great post content to read while smiling :D',
            ]);
    }

    private function authenticateUser(): User
    {
        $user = User::factory()->create(['name' => 'The Author']);
        Sanctum::actingAs($user);
        return $user;
    }

}
