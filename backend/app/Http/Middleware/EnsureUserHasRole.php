<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Normalize roles: 'mentor' and 'dudi' are treated as interchangeable aliases
        $allowed = [];
        foreach ($roles as $role) {
            $allowed[] = $role;
            if ($role === 'mentor') {
                $allowed[] = 'dudi';
            } elseif ($role === 'dudi') {
                $allowed[] = 'mentor';
            }
        }

        if (! in_array($user->role, $allowed, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki hak akses (role) untuk modul ini.',
                'required_roles' => $roles,
                'your_role' => $user->role,
            ], 403);
        }

        return $next($request);
    }
}
