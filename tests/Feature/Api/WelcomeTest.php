<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_root_endpoint_returns_welcome(): void
    {
        $response = $this->getJson('/api/v1');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'name',
                    'version',
                    'documentation',
                    'endpoints' => ['states', 'banks', 'holidays'],
                ],
            ])
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Naija Data API');
    }

    public function test_unknown_endpoint_returns_404_envelope(): void
    {
        $response = $this->getJson('/api/v1/does-not-exist');

        $response->assertNotFound()
            ->assertJson([
                'success' => false,
                'message' => 'Endpoint not found.',
            ]);
    }
}