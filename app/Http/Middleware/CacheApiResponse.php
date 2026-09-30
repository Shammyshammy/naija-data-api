<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheApiResponse
{
    public function handle(Request $request, Closure $next, int $ttl = 300): Response
    {
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        $key = 'api_cache:' . md5($request->fullUrl());

        if (Cache::has($key)) {
            $cached = Cache::get($key);

            return response($cached['body'], $cached['status'])
                ->withHeaders($cached['headers'])
                ->header('X-Cache', 'HIT');
        }

        $response = $next($request);

        if ($response->isSuccessful()) {
            Cache::put($key, [
                'body'    => $response->getContent(),
                'status'  => $response->getStatusCode(),
                'headers' => $response->headers->all(),
            ], $ttl);
        }

        return $response->header('X-Cache', 'MISS');
    }
}