<?php

use App\Http\Controllers\Api\V1\BankController;
use App\Http\Controllers\Api\V1\HolidayController;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Welcome
    Route::get('/', function () {
        return ApiResponse::success([
            'name'          => 'Naija Data API',
            'version'       => '1.0.0',
            'documentation' => url('/docs/api'),
            'endpoints'     => [
                'states'    => url('/api/v1/states'),
                'banks'     => url('/api/v1/banks'),
                'holidays'  => url('/api/v1/holidays'),
            ],
        ], 'Welcome to Naija Data API.');
    });

    // States
    Route::prefix('states')->group(function () {
        Route::get('/', [StateController::class, 'index']);
        Route::get('/regions', [StateController::class, 'regions']);
        Route::get('/{identifier}', [StateController::class, 'show']);
        Route::get('/{identifier}/lgas', [StateController::class, 'lgas']);
    });

    // Banks
    Route::prefix('banks')->group(function () {
        Route::get('/', [BankController::class, 'index']);
        Route::get('/types', [BankController::class, 'types']);
        Route::get('/{identifier}', [BankController::class, 'show']);
    });

    // Holidays
    Route::prefix('holidays')->group(function () {
        Route::get('/', [HolidayController::class, 'index']);
        Route::get('/years', [HolidayController::class, 'years']);
        Route::get('/year/{year}', [HolidayController::class, 'year']);
    });
});