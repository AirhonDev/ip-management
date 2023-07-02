<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_required_input()
    {
        $response = $this->json('POST', '/api/login', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function it_returns_token_when_valid_credentials_are_provided()
    {
        User::factory()->create([
            'email' => 'test@user.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'test@user.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'token',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    public function it_validates_wrong_credentials_pass()
    {
        User::factory()->create([
            'email' => 'test@user.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'invalid@user.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'email'
                    ]
                ]
            );
    }
}
