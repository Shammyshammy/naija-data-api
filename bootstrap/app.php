<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return match (true) {
                $e instanceof \Illuminate\Validation\ValidationException
                    => \App\Http\Responses\ApiResponse::error('Validation failed.', 422, $e->errors()),
                $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
                    => \App\Http\Responses\ApiResponse::error('Resource not found.', 404),
                $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
                    => \App\Http\Responses\ApiResponse::error('Endpoint not found.', 404),
                $e instanceof \Illuminate\Auth\AuthenticationException
                    => \App\Http\Responses\ApiResponse::error('Unauthenticated.', 401),
                $e instanceof \Illuminate\Auth\Access\AuthorizationException
                    => \App\Http\Responses\ApiResponse::error('Forbidden.', 403),
                $e instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException
                    => \App\Http\Responses\ApiResponse::error('Too many requests.', 429),
                default => null,
            };
        });
    })->create();