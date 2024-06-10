<?php

namespace App\Http\Controllers\Schools;

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

        return view('auth.school');

    }

    public function subscription(){

        return view('auth.subscription');

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect('school/home');

        } else {

            return back()->withErrors(['email' => 'Invalid credentials']);

        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }





}
