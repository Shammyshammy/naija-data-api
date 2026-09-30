<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class HolidayApiTest extends TestCase
{
    public function test_can_list_holidays(): void
    {
        $this->createHoliday(['name' => 'Christmas Day', 'date' => '2026-12-25', 'year' => 2026]);
        $this->createHoliday(['name' => 'New Year', 'date' => '2026-01-01', 'year' => 2026]);

        $response = $this->getJson('/api/v1/holidays');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'date', 'year', 'type']],
            ]);
    }

    public function test_can_filter_holidays_by_year(): void
    {
        $this->createHoliday(['year' => 2026, 'date' => '2026-12-25']);
        $this->createHoliday(['year' => 2027, 'date' => '2027-12-25']);

        $response = $this->getJson('/api/v1/holidays?year=2026');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
    }

    public function test_can_filter_holidays_by_type(): void
    {
        $this->createHoliday(['type' => 'public', 'date' => '2026-01-01']);
        $this->createHoliday(['type' => 'religious', 'date' => '2026-04-03']);

        $response = $this->getJson('/api/v1/holidays?type=religious');

        $response->assertOk();
        $this->assertEquals(1, $response->json('meta.total'));
    }

    public function test_can_get_holidays_for_year(): void
    {
        $this->createHoliday(['year' => 2026, 'date' => '2026-01-01']);
        $this->createHoliday(['year' => 2026, 'date' => '2026-12-25']);
        $this->createHoliday(['year' => 2027, 'date' => '2027-01-01']);

        $response = $this->getJson('/api/v1/holidays/year/2026');

        $response->assertOk()
            ->assertJsonPath('data.year', 2026)
            ->assertJsonPath('data.count', 2)
            ->assertJsonCount(2, 'data.holidays');
    }

    public function test_year_with_no_holidays_returns_empty(): void
    {
        $response = $this->getJson('/api/v1/holidays/year/2020');

        $response->assertOk()
            ->assertJsonPath('data.count', 0)
            ->assertJsonCount(0, 'data.holidays');
    }

    public function test_can_list_available_years(): void
    {
        $this->createHoliday(['year' => 2026, 'date' => '2026-01-01']);
        $this->createHoliday(['year' => 2027, 'date' => '2027-01-01']);

        $response = $this->getJson('/api/v1/holidays/years');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }
}