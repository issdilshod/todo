<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        if (auth()->check()){
            return redirect()->route('home');
        }else{
            return redirect()->route('loginView');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }

    public function loginView()
    {
        return view('pages.login');
    }

    public function register(Request $request)
    {
        $user = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:8|confirmed',
            'name' => 'required'
        ],
        [
            'password.confirmed' => 'Passwords not match'
        ]);
 
        $user = User::create($user);

        auth()->login($user);
 
        return redirect()->route('home')->with('msg', 'Successfully registered');
    }

    public function registerView()
    {
        return view('pages.register');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('loginView');
    }

}
