<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * List holidays, optionally filtered by year or type
     */
    public function index(Request $request)
    {
        $query = Holiday::query();

        if ($request->filled('year')) {
            $query->where('year', (int) $request->year);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $perPage = min((int) $request->input('per_page', 50), 100);
        $holidays = $query->orderBy('date')->paginate($perPage);

        return ApiResponse::paginated($holidays, 'Holidays retrieved successfully.');
    }

    /**
     * Get holidays for a specific year
     */
    public function year(int $year)
    {
        $holidays = Holiday::where('year', $year)
            ->orderBy('date')
            ->get();

        return ApiResponse::success([
            'year'     => $year,
            'count'    => $holidays->count(),
            'holidays' => $holidays,
        ], "Holidays for {$year} retrieved successfully.");
    }

    /**
     * List available years
     */
    public function years()
    {
        $years = Holiday::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return ApiResponse::success($years, 'Available years retrieved successfully.');
    }
}