<?php

namespace Tests\Feature\AccountTests;

use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

    /**
     * User can register because all information correct
     *
     * @return void
     */
    public function test_can_register(): void
    {
        $this->postJson(route('auth.register'), [
            'name'     => 'test name',
            'email'    => 'user@taskapp.com',
            'password' => 'secret-test'
        ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'id'    => 'string',
                    'name'  => 'string',
                    'email' => 'string'
                ])->missing('password')
            );
    }


    /**
     * User can't register because information not correct
     *
     * @return void
     */
    public function test_cannot_register_because_validation_error(): void
    {
        $this->postJson(route('auth.register'), [
            'name'     => 'test name',
            'email'    => 'bad-email',
            'password' => 'short'
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
            );
    }

    /**
     * User can't register because email already registered
     *
     * @return void
     */
    public function test_cannot_register_because_email_exists(): void
    {
        User::factory()->create([
            'name'     => 'test name',
            'email'    => 'user@taskapp.com',
            'password' => Hash::make('secretpass'),
        ]);
        $this->postJson(route('auth.register'), [
            'name'     => 'test name',
            'email'    => 'user@taskapp.com',
            'password' => 'short'
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
                    ->where('errors.email.0', 'The email has already been taken.')
            );
    }

}
