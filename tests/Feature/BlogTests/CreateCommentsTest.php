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

class CreateCommentsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Authenticated user can create comment with valid input data
     *
     * @return void
     */
    public function test_can_create_comment_if_authenticated(): void
    {
        $user = $this->authenticateUser();
        $post = $this->getPost();
        $this->postJson(route('posts.comments.create', ['id' => $post->id] ), [
                'body'  => 'Amazing Post to ready :D!'
            ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'id'         => 'string',
                    'body'       => 'string',
                    'created_at' => 'string',
                    'user'       => 'array'
                ])
            );
    }

    /**
     * Authenticated user can't create comment with empty or invalid input data
     *
     * @return void
     */
    public function test_cannot_create_comment_because_validation_error(): void
    {
        $this->authenticateUser();
        $post = $this->getPost();
        $this->postJson(route('posts.comments.create', ['id' => $post->id] ))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
            );
    }

    /**
     * Unauthenticated user can't create comment even if valid input data
     *
     * @return void
     */
    public function test_cannot_create_comment_if_not_authenticated(): void
    {
        $post = $this->getPost();
        $this->postJson(route('posts.comments.create', ['id' => $post->id]), [
                'body'  => 'Amazing Post to ready :D!'
            ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','Unauthenticated.')
            );
    }


    /**
     * authenticated user can't create comment if post not exists or deleted
     *
     * @return void
     */
    public function test_cannot_create_comment_if_post_not_exists(): void
    {
        $this->authenticateUser();
        $post = $this->getPost();
        $this->postJson(route('posts.comments.create', ['id' => Str::uuid()]), [
                'body'  => 'Amazing Post to ready :D!'
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('message','string')
                ->etc()
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
