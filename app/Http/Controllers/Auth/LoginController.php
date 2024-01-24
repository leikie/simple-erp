<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        #ambil form request lalu diberikan aturan validasi
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string'
        ]);

        $remember = ($request->remember == 1) ? true : false;
        $credentials = ['email' => $request->email, 'password' => $request->password];

        if ($attemp = Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Login Successfully!');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }
}
