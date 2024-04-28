<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class VerifyUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user && $user->status != 1) {
            Auth::logout();
            $request->session()->flush();
            $request->session()->regenerate();
            // return redirect()->route('web.section');
           return redirect()->route('web.section')->with('success',trans('genirale.Youraccounthasbeentemporarilysuspended'));
        }
        return $next($request);
    }
}
