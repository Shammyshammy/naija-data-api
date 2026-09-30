<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * List all states
     */
    public function index(Request $request)
    {
        $query = State::query();

        // Optional filter by region
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Optional search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('capital', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $perPage = min((int) $request->input('per_page', 50), 100);
        $states = $query->orderBy('name')->paginate($perPage);

        return ApiResponse::paginated($states, 'States retrieved successfully.');
    }

    /**
     * Get a single state by code or slug
     */
    public function show(string $identifier)
    {
        $state = State::where('code', strtoupper($identifier))
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        return ApiResponse::success($state, 'State retrieved successfully.');
    }

    /**
     * Get LGAs of a state
     */
    public function lgas(string $identifier)
    {
        $state = State::where('code', strtoupper($identifier))
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        $lgas = $state->lgas()->orderBy('name')->get();

        return ApiResponse::success([
            'state' => [
                'name' => $state->name,
                'code' => $state->code,
            ],
            'count' => $lgas->count(),
            'lgas'  => $lgas,
        ], 'LGAs retrieved successfully.');
    }

    /**
     * Get all regions
     */
    public function regions()
    {
        $regions = State::select('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');

        return ApiResponse::success($regions, 'Regions retrieved successfully.');
    }
}