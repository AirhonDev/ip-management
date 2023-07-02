<?php

namespace Tests\Feature\Api;

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
}
