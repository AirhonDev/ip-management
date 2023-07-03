<?php

namespace Tests\Feature\Api;

use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IpAddressControllerTest extends TestCase
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

        $url = '/api/ip-address?' . http_build_query($parameters);

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

        $url = '/api/ip-address?' . http_build_query($parameters);

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

    public function it_should_return_validation_errors_for_invalid_pagination_data()
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
            'per_page' => 'test'
        ];

        $url = '/api/ip-address?' . http_build_query($parameters);

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

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => auth()->id(),
            'method' => 'GET',
            'request_path' => 'api/ip-address',
            'payload' => json_encode([
                'per_page' => 'test'
            ]),
        ]);
    }

    /** @test */
    public function it_ipaddress_endpoint_exists()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post('/api/ip-address', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_required_input()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post('/api/ip-address', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['ip_address', 'label']);
    }

    /** @test */
    public function it_should_return_200_with_ip_address_data()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post('/api/ip-address', [
            'ip_address' => '192.0.2.1',
            'label' => 'IT Department'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'ip_address',
                ]
            ]);
    }

    /** @test */
    public function it_should_return_422_for_invalid_ip_address()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post('/api/ip-address', [
            'ip_address' => '555555',
            'label' => 'IT Department'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'ip_address'
                    ]
                ]
            );
    }

    /** @test */
    public function it_should_has_audit_logs()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->post('/api/ip-address', [
            'ip_address' => '192.0.2.1',
            'label' => 'IT Department'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'ip_address',
                ]
            ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => auth()->id(),
            'method' => 'POST',
            'request_path' => 'api/ip-address',
            'payload' => json_encode([
                'ip_address' => '192.0.2.1',
                'label' => 'IT Department'
            ]),
        ]);
    }

    /** @test */
    public function it_should_exists_endpoint_to_update_ip_and_label_and_should_not_return_404()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
        );

        $ipAddress = IpAddress::factory()->create();
        $label = $ipAddress->labels()->create([
            'label' => fake()->name(),
            'user_id' => $user
        ]);

        $response = $this->put("/api/ip-address/$ipAddress->id/$label->id");

        $response->assertStatus(422);
    }

    /** @test */
    public function it_should_return_200_success_for_right_parameters()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
        );

        $ipAddress = IpAddress::factory()->create();
        $label = $ipAddress->labels()->create([
            'label' => fake()->name(),
            'user_id' => $user
        ]);

        $response = $this->put("/api/ip-address/$ipAddress->id/$label->id", [
            'ip_address' => $ip = fake()->ipv4(),
            'label' => 'New Department'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'ip_address',
                ]
            ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => auth()->id(),
            'method' => 'PUT',
            'request_path' => "api/ip-address/$ipAddress->id/$label->id",
            'payload' => json_encode([
                'ip_address' => $ip,
                'label' => 'New Department'
            ]),
        ]);
    }
}
