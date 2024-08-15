<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Restrict admins from accessing the users form
            if ($role === 'admin' && $user->role === 'admin') {
                return redirect()->route('home')->with('error', 'Admins cannot access the users form.');
            }

            // Allow superadmins to access the users form
            if ($role === 'superadmin' && $user->role === 'superadmin') {
                return $next($request);
            }
        }

        return $next($request);
    }
}