<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class authSchool
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user && $user->model !== 'App\Models\Schools') {
           return redirect()->back();
        }
        return $next($request);
    }
}
