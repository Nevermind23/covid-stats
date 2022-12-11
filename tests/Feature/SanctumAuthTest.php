<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Tests\TestCase;

class SanctumAuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_login(?string $email = null, string $password = 'password')
    {
        $email ??= User::factory()->withCustomPassword($password)->create()->email;

        $response = $this->postJson(route('api.login'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('name', $response['user']);
        $this->assertArrayHasKey('email', $response['user']);
        $this->assertArrayHasKey('token', $response);

        $this->test_logout($response['token']);
    }

    public function test_login_with_custom_password()
    {
        $this->test_login(null, $this->faker->password(10));
    }

    public function test_login_invalid_password()
    {
        $user ??= User::factory()->create();

        $response = $this->postJson(route('api.login'), [
            'email' => $user['email'],
            'password' => 'password_invalid',
        ]);
        $response->assertStatus(422);
        $response->assertSeeText(Lang::get('messages.invalid_password'));

        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('password', $response['errors']);
    }

    public function test_login_invalid_email()
    {
        $user ??= User::factory()->create();

        $response = $this->postJson(route('api.login'), [
            'email' => "invalid_{$user['email']}",
            'password' => 'password',
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('errors', $response);
        $this->assertArrayHasKey('email', $response['errors']);
    }

    public function test_login_authentication()
    {
        $this->actingAsUser();
        $user = User::factory()->definition();

        $response = $this->postJson(route('api.login'), [
            'email' => $user['email'],
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_register()
    {
        $userData = User::factory()->definition();
        $userData['password'] = $this->faker->password(10);

        $response = $this->postJson(route('api.register'), $userData);

        $response->assertStatus(200);
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('name', $response['user']);
        $this->assertArrayHasKey('email', $response['user']);

        $this->assertArrayHasKey('token', $response);

        $this->test_login($userData['email'], $userData['password']);

        $this->test_logout($response['token']);
    }

    public function test_logout(string $token = null)
    {
        if (is_null($token)) {
            $token = $this->user->createToken(Str::random())->plainTextToken;
        }

        $headers = [
            'Authorization' => "Bearer $token"
        ];

        $response = $this->postJson(route('api.logout'), [], $headers);
        $response->assertStatus(200);

        $response->assertSeeText(Lang::get('messages.logout_success'));
        $this->assertArrayHasKey('message', $response);
    }

    public function test_logout_authentication()
    {
        $response = $this->postJson(route('api.logout'));
        $response->assertStatus(401);
    }
}
