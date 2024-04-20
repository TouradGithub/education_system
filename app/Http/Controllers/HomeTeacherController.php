<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeTeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('acadimy')->attempt($credentials)) {
        return redirect('/home');
    } else {

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}

    public function index()
    {
        return view('home');
    }

    public function getLogin()
    {
        return view('auth.teacher');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }
}
