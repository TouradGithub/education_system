<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
     public function __construct()
     {
          $this->middleware('guest')->except('logout');
     }

    public function getLogin(){

        return view('auth.teacher');

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials)) {

            return redirect('teacher/home');

        } else {

            return back()->withErrors(['email' => 'Invalid credentials']);

        }

    }
    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }
}
