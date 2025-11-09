<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has the required role
        if (auth()->user()->role !== $role && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }else if (auth()->user()->role !== $role && auth()->user()->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        return $next($request);
    }
}