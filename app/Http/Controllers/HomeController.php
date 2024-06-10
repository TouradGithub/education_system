<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function loginAcadimy(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::guard('acadimy')->attempt($credentials)) {
            if (auth('acadimy')->check()) {

                return "oui";
            }
            return redirect('/home');

        } else {

            return back()->withErrors(['email' => 'Invalid credentials']);

        }

    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/home');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function index()
    {
        return view('home');
    }

    public function getSection(){
        return view('selection');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('web.section');
    }

    public function logoutAcadimy(Request $request)
    {
        Auth::guard('acadimy')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }


}
