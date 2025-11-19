<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Supervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || (auth()->user()->role !== 'lecturer' && auth()->user()->role !== 'admin')) {
            abort(403, 'Unauthorized. Only lecturers and admins can access this area.');
        }

        return $next($request);
    }
}
