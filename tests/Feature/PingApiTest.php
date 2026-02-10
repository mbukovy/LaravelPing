<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_ping_stores_data_and_returns_ok(): void
    {
        $response = $this->postJson('/api/ping', [
            'uuid' => 'device-abc-123',
            'battery_percent' => 85,
        ]);

        $response->assertStatus(200)
            ->assertExactJson(['status' => 'ok']);

        $this->assertDatabaseHas('pings', [
            'uuid' => 'device-abc-123',
            'battery_percent' => 85,
        ]);
    }
}
