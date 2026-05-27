<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
