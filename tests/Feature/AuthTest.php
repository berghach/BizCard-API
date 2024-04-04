<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_token()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->postJson('/api/token', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(200);
    }

    public function test_signup()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/signup', $userData);

        $response->assertStatus(200);
    }
}
