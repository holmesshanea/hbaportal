<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->user()->role, ['Super', 'Admin'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
