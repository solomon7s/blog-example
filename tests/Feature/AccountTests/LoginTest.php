<?php

namespace Tests\Feature;

use App\Models\Account\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * User can login with the same registered information.
     *
     * @return void
     */
    public function test_can_login(): void
    {
        User::factory()->create([
            'name'     => 'Test Name',
            'email'    => 'user@taskapp.com',
            'password' => Hash::make('secret-pass'),
        ]);
        $this->postJson(route('auth.login'), [
            'username' => 'user@taskapp.com',
            'password' => 'secret-pass'
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'access_token' => 'string',
                    'user'         => 'array'
                ])->whereAll([
                    'user.name'  => 'Test Name',
                    'user.email' => 'user@taskapp.com'
                ])->missing('password')
            );
    }


    /**
     * User can't login with incorrect information.
     *
     * @return void
     */
    public function test_cannot_login_because_wrong_credentials(): void
    {
        User::factory()->create([
            'name'     => 'Test Name',
            'email'    => 'user@taskapp.com',
            'password' => Hash::make('secret-pass'),
        ]);
        $this->postJson(route('auth.login'), [
            'username' => 'user@taskapp.com',
            'password' => 'wrong-pass'
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message','The given data was invalid.')
                    ->whereType('errors', 'array')
                    ->where('errors.username.0', 'The provided credentials are incorrect.')
            );
    }


}
