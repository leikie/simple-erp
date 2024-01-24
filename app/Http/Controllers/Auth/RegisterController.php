<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        #ambil form request lalu diberikan aturan validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $new_user->assignRole('visitor');
        return redirect()->route('register')->with('success', 'User created successfully!');
    }
}
