<?php

namespace Biztory\Storefront\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiDataResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $data = match ($response->getStatusCode()) {
            200, 201 => $response->original,
            422 => $response->exception->errors(),
            default => $response->exception,
        };

        return response()->json([
            'code' => $response->getStatusCode(),
            'message' => $response->isSuccessful() ? 'Success' : $response->exception->getMessage(),
            'data' => $data,
        ], $response->getStatusCode());
    }
}
