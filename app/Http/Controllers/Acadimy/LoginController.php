<?php

namespace App\Http\Controllers\Acadimy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

    public function getLogin(){

        return view('auth.acadimy');

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user) {
                // return $user;
                return redirect('acadimic/home');
            } else {
                Auth::logout(); // Log out to ensure a clean state
                return back()->withErrors(['email' => 'User not found']);
            }

        }else {

            return back()->withErrors(['email' => 'Invalid credentials']);

        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('web.section');
    }
}
