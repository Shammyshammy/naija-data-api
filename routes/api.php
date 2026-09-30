<?php

use App\Http\Controllers\Api\V1\BankController;
use App\Http\Controllers\Api\V1\HolidayController;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('cache.api:300')->group(function () {

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


    Route::get('/health', function () {
    $checks = [
        'database' => \DB::connection()->getPdo() ? 'ok' : 'down',
        'cache'    => \Cache::has('health_check') || \Cache::put('health_check', true, 60) ? 'ok' : 'down',
    ];

    $healthy = ! in_array('down', $checks);

    return \App\Http\Responses\ApiResponse::success([
        'status'  => $healthy ? 'healthy' : 'unhealthy',
        'checks'  => $checks,
        'version' => '1.0.0',
        'time'    => now()->toIso8601String(),
    ], 'Health check.', $healthy ? 200 : 503);
})->withoutMiddleware('cache.api');
});