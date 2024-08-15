<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Bouncer
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



    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     $name = $request->query("name");

    //     // Log the name parameter
    //     // Log::info('Name parameter: ' . $name);

    //     if (!Str::startsWith($name, 'A')) {
    //         // Log::info('Name does not start with A');
    //         return response("Your name does not start with A");
    //     }

    //     // Log::info('Name starts with A, proceeding to next middleware');
    //     return $next($request);
    // }
}
