<?php

namespace Tests;

use App\Models\Bank;
use App\Models\Holiday;
use App\Models\Lga;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function createState(array $attributes = []): State
    {
        $id = Str::random(6);

        return State::create(array_merge([
            'name'      => "Test State {$id}",
            'slug'      => "test-state-{$id}",
            'code'      => strtoupper($id),
            'capital'   => 'Test Capital',
            'region'    => 'South East',
            'lga_count' => 5,
            'latitude'  => 6.5,
            'longitude' => 7.5,
        ], $attributes));
    }

    protected function createLga(State $state, array $attributes = []): Lga
    {
        return Lga::create(array_merge([
            'state_id' => $state->id,
            'name'     => 'Test LGA ' . Str::random(4),
            'slug'     => 'test-lga-' . Str::random(6),
        ], $attributes));
    }

    protected function createBank(array $attributes = []): Bank
    {
        $id = Str::random(6);

        return Bank::create(array_merge([
            'name'      => "Test Bank {$id}",
            'slug'      => "test-bank-{$id}",
            'code'      => (string) rand(100000, 999999),
            'type'      => 'commercial',
            'is_active' => true,
        ], $attributes));
    }

    protected function createHoliday(array $attributes = []): Holiday
    {
        return Holiday::create(array_merge([
            'name'        => 'Test Holiday ' . Str::random(4),
            'date'        => '2026-12-25',
            'year'        => 2026,
            'type'        => 'public',
            'description' => 'A test holiday',
        ], $attributes));
    }
}