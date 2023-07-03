<?php

namespace Tests\Feature\Api;

use App\Models\IpAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class AuditLogControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_authorization()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_should_return_paginated_results()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
        );

        Sanctum::actingAs(
            $user = User::factory()->create(),
        );

        $ipAddressCollection = IpAddress::factory(10)->create();

        $ipAddressCollection->map(function ($ip) use ($user) {
            $ip->labels()->create([
                'label' => fake()->name(),
                'user_id' => $user
            ]);
        });

        $parameters = [];

        $url = '/api/ip-address?' . http_build_query($parameters);

        $response = $this->get($url);

        $parameters = [
            'per_page' => 10,
        ];

        $url = '/api/audit-logs?' . http_build_query($parameters);

        $response = $this->get($url);

        $data = $response->json()['data'];
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page'
                ],
            ]);

        $this->assertNotEmpty($data);
    }
}
