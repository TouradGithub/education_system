<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class VerifySettingSchool
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $school = getSchool();
        // dd($school->setting);
        if (!$user ||
        !$school->setting ||
        !$school->setting->school_name ||
        !$school->setting->school_email ||
        !$school->setting->school_mobile ||
        !$school->setting->school_description ||
        !$school->setting->school_address)
    {
        return redirect()->route('school.setting-index')
                         ->with('success', 'School settings are not complete. Please update them.');
    }
        return $next($request);
    }
}
