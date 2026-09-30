<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class SystemTest extends TestCase
{
    public function test_health_check_returns_healthy(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'healthy')
            ->assertJsonPath('data.checks.database', 'ok');
    }

    public function test_rate_limit_headers_are_present(): void
    {
        $response = $this->getJson('/api/v1/states');

        $response->assertOk()
            ->assertHeader('X-RateLimit-Limit');
    }

    public function test_cache_headers_are_present(): void
    {
        $response = $this->getJson('/api/v1/states');

        $response->assertOk()
            ->assertHeader('X-Cache');
    }

    public function test_second_request_hits_cache(): void
    {
        $this->getJson('/api/v1/states')->assertHeader('X-Cache', 'MISS');

        $this->getJson('/api/v1/states')->assertHeader('X-Cache', 'HIT');
    }

    public function test_cors_allows_any_origin(): void
    {
        $response = $this->withHeaders([
            'Origin' => 'https://example.com',
        ])->getJson('/api/v1/states');

        $response->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', '*');
    }
}