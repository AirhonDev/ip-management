<?php

namespace Tests\Feature\Api;

use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class IpAddressLabelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

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

        $ipAddressCollection = IpAddress::factory(10)->create();

        $ipAddressCollection->map(function ($ip) use ($user) {
            $ip->labels()->create([
                'label' => fake()->name(),
                'user_id' => $user
            ]);
        });

        $parameters = [
            'per_page' => 10,
        ];

        $url = '/api/labels?' . http_build_query($parameters);

        $response = $this->get($url);

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
    }

    public function it_should_return_validation_errors_for_invalid_pagination_request()
    {
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

        $url = '/api/labels?' . http_build_query($parameters);

        $response = $this->get($url);

        $response->assertStatus(422)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'per_page'
                    ]
                ]
            );
    }

    /** @test */
    public function it_ipaddress_endpoint_exists()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $ipAddress = IpAddress::factory()->create();

        $response = $this->post("/api/labels/$ipAddress->id", []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_should_return_200_success_for_right_parameters()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
        );

        $ipAddress = IpAddress::factory()->create();

        $response = $this->post("/api/labels/$ipAddress->id", [
            'label' => 'Test Department'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'ip_address_id',
                    'user',
                    'label',
                    'created_at',
                ]
            ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => auth()->id(),
            'method' => 'POST',
            'request_path' => "api/labels/$ipAddress->id",
            'payload' => json_encode([
                'label' => 'Test Department'
            ]),
        ]);
    }
}
