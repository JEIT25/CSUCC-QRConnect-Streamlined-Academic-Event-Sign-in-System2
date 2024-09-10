<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($credentials)){
            throw ValidationException::withMessages([
                'email' => 'Authentication Failed'
            ]); //if the auth attemp fails,
                //use ValidationExcption to throw new validation message to form error message in the front end
        }

        $request->session()->regenerate(); //regenerate session id each time log in is successful
        if ($request->user()->type == "facilitator") {
            return redirect()->intended(route('homepage'))->with('success', "Log In Success!");
        }
    }

        public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }
}

