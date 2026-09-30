<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * List all banks
     */
    public function index(Request $request)
    {
        $query = Bank::query();

        // Filter by type: commercial, microfinance, non_interest, merchant
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = min((int) $request->input('per_page', 50), 100);
        $banks = $query->orderBy('name')->paginate($perPage);

        return ApiResponse::paginated($banks, 'Banks retrieved successfully.');
    }

    /**
     * Get a single bank by code or slug
     */
    public function show(string $identifier)
    {
        $bank = Bank::where('code', $identifier)
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        return ApiResponse::success($bank, 'Bank retrieved successfully.');
    }

    /**
     * List bank types
     */
    public function types()
    {
        $types = Bank::select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return ApiResponse::success($types, 'Bank types retrieved successfully.');
    }
}