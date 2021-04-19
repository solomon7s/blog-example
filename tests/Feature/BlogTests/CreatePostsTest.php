<?php

namespace Tests\Feature\BlogTests;

use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePostsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Authenticated user can create post with valid input data
     *
     * @return void
     */
    public function test_can_create_post_if_authenticated(): void
    {
        $this->authenticateUser();
        $this->postJson(route('posts.create'), [
            'title'   => 'Amazing new Post',
            'content' => 'super great post content to read while smiling :D',
        ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'id'             => 'string',
                    'title'          => 'string',
                    'content'        => 'string',
                    'is_featured'    => 'boolean',
                    'comments_count' => 'integer',
                    'created_at'     => 'string',
                    'user'           => 'array'
                ])
            );
    }

    /**
     * Authenticated user can't create post with empty or invalid input data
     *
     * @return void
     */
    public function test_cannot_create_post_because_validation_error(): void
    {
        $this->authenticateUser();
        $this->postJson(route('posts.create'))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
            );
    }

    /**
     * Unauthenticated user can't create post even if valid input data
     *
     * @return void
     */
    public function test_cannot_create_post_if_not_authenticated(): void
    {
//        $this->authenticateUser();
        $this->postJson(route('posts.create'), [
            'title'   => 'Amazing new Post',
            'content' => 'super great post content to read while smiling :D',
        ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','Unauthenticated.')
            );
    }


    private function authenticateUser(): void
    {
        Sanctum::actingAs(
            User::factory()->create([
                'name'     => 'The Author'
            ])
        );
    }

}
