<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsHabit
{
    public function handle(Request $request, Closure $next): Response
    {
        $habit = $request->route('habit');

        if ($habit && $habit->user_id !== $request->user()->id) {
            abort(403, 'This habit does not belong to you.');
        }

        return $next($request);
    }
}
