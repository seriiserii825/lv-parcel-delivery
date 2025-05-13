<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the user from route parameters
        $user = $request->user(); // Ensure route model binding is working

        if (!$user instanceof User) {
            return response()->json(['message' => 'User with role admin not found'], 404);
        }

        // Check if the user has role 'student'
        if ($user->role === 'admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized - Not a Admin'], 403);
    }
}
