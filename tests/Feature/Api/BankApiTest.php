<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class BankApiTest extends TestCase
{
    public function test_can_list_banks(): void
    {
        $this->createBank(['name' => 'Access Bank', 'code' => '044']);
        $this->createBank(['name' => 'GTBank', 'code' => '058']);

        $response = $this->getJson('/api/v1/banks');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [['id', 'name', 'code', 'type', 'is_active']],
            ]);

        $this->assertGreaterThanOrEqual(2, $response->json('meta.total'));
    }

    public function test_can_filter_banks_by_type(): void
    {
        $this->createBank(['name' => 'Access Bank', 'code' => '044', 'type' => 'commercial']);
        $this->createBank(['name' => 'Kuda', 'code' => '50211', 'type' => 'microfinance']);

        $response = $this->getJson('/api/v1/banks?type=microfinance');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
        $this->assertEquals('Kuda', $response->json('data.0.name'));
    }

    public function test_can_search_banks(): void
    {
        $this->createBank(['name' => 'Access Bank', 'code' => '044']);
        $this->createBank(['name' => 'GTBank', 'code' => '058']);

        $response = $this->getJson('/api/v1/banks?search=access');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
    }

    public function test_can_get_bank_by_code(): void
    {
        $this->createBank(['name' => 'Access Bank', 'code' => '044']);

        $response = $this->getJson('/api/v1/banks/044');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Access Bank')
            ->assertJsonPath('data.code', '044');
    }

    public function test_can_get_bank_by_slug(): void
    {
        $this->createBank(['name' => 'Access Bank', 'slug' => 'access-bank', 'code' => '044']);

        $response = $this->getJson('/api/v1/banks/access-bank');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Access Bank');
    }

    public function test_unknown_bank_returns_404(): void
    {
        $response = $this->getJson('/api/v1/banks/999999');

        $response->assertNotFound()
            ->assertJson(['success' => false]);
    }

    public function test_can_list_bank_types(): void
    {
        $this->createBank(['type' => 'commercial']);
        $this->createBank(['type' => 'microfinance']);
        $this->createBank(['type' => 'commercial']);

        $response = $this->getJson('/api/v1/banks/types');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }
};