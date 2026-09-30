<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class StateApiTest extends TestCase
{
    public function test_can_list_states(): void
    {
        $this->createState(['name' => 'Lagos', 'code' => 'LAG', 'slug' => 'lagos']);
        $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers']);

        $response = $this->getJson('/api/v1/states');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [['id', 'name', 'code', 'capital', 'region']],
                'meta' => ['current_page', 'per_page', 'total', 'last_page'],
                'links',
            ]);

        $this->assertGreaterThanOrEqual(2, $response->json('meta.total'));
    }

    public function test_can_filter_states_by_region(): void
    {
        $this->createState(['name' => 'Lagos', 'code' => 'LAG', 'slug' => 'lagos', 'region' => 'South West']);
        $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers', 'region' => 'South South']);

        $response = $this->getJson('/api/v1/states?region=South West');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
        $this->assertEquals('Lagos', $response->json('data.0.name'));
    }

    public function test_can_search_states(): void
    {
        $this->createState(['name' => 'Lagos', 'code' => 'LAG', 'slug' => 'lagos']);
        $this->createState(['name' => 'Kano', 'code' => 'KAN', 'slug' => 'kano']);

        $response = $this->getJson('/api/v1/states?search=lag');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
    }

    public function test_can_get_state_by_code(): void
    {
        $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers']);

        $response = $this->getJson('/api/v1/states/RIV');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Rivers')
            ->assertJsonPath('data.code', 'RIV');
    }

    public function test_can_get_state_by_slug(): void
    {
        $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers']);

        $response = $this->getJson('/api/v1/states/rivers');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Rivers');
    }

    public function test_state_lookup_is_case_insensitive(): void
    {
        $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers']);

        $response = $this->getJson('/api/v1/states/riv');

        $response->assertOk()
            ->assertJsonPath('data.code', 'RIV');
    }

    public function test_unknown_state_returns_404(): void
    {
        $response = $this->getJson('/api/v1/states/ZZZ');

        $response->assertNotFound()
            ->assertJson(['success' => false]);
    }

    public function test_can_get_state_lgas(): void
    {
        $state = $this->createState(['name' => 'Rivers', 'code' => 'RIV', 'slug' => 'rivers']);
        $this->createLga($state, ['name' => 'Port Harcourt']);
        $this->createLga($state, ['name' => 'Obio-Akpor']);

        $response = $this->getJson('/api/v1/states/RIV/lgas');

        $response->assertOk()
            ->assertJsonPath('data.state.name', 'Rivers')
            ->assertJsonPath('data.count', 2)
            ->assertJsonCount(2, 'data.lgas');
    }

    public function test_can_list_regions(): void
    {
        $this->createState(['region' => 'South East']);
        $this->createState(['region' => 'South West']);
        $this->createState(['region' => 'South East']);

        $response = $this->getJson('/api/v1/states/regions');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    public function test_pagination_respects_per_page(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            $this->createState(['name' => "State {$i}", 'code' => "S{$i}", 'slug' => "state-{$i}"]);
        }

        $response = $this->getJson('/api/v1/states?per_page=5');

        $response->assertOk()
            ->assertJsonPath('meta.per_page', 5)
            ->assertJsonCount(5, 'data');
    }

    public function test_per_page_is_capped_at_100(): void
    {
        $this->createState();

        $response = $this->getJson('/api/v1/states?per_page=500');

        $response->assertOk()
            ->assertJsonPath('meta.per_page', 100);
    }
}