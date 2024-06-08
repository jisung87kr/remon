<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class AppEnvRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(env('APP_ENV') == 'production'){
            if (Auth::check()) {
                return $next($request);
            }

            $currentRoute = Route::current();

            if ($currentRoute && !$this->isActionName($currentRoute)) {
                return redirect()->route('login'); // Assuming 'login' is the name of your login route
            }
        }

        return $next($request);
    }

    private function isActionName($route): bool
    {
        $actionName = [
            'Laravel\Fortify\Http\Controllers\AuthenticatedSessionController@create',
            'Laravel\Fortify\Http\Controllers\AuthenticatedSessionController@store',
            // Add more routes if necessary
        ];

        return in_array($route->getActionName(), $actionName);
    }
}
