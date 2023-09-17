<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            if (Auth::guard('apipatient')->check()) {
                return route('patient.dashboard');
            }
            elseif (Auth::guard('apidoctor')->check()) {
                return route('doctor.dashboard');
            }
            elseif (Auth::guard('apiadmin')->check()) {
                return route('admin.dashboard');
            }
            else {
                return route('home');
            }
        }
    }
}
