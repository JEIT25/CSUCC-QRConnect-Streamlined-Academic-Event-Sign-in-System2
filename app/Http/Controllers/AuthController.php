<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
        // Validate credentials
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Attempt authentication
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Authentication Failed',
            ]); // if the auth attempt fails, return validation error
        }

        // Check if the authenticated user's account status is 'disabled'
        if (Auth::user()->acc_status === 'disabled') {
            Auth::logout(); // Log out the user immediately
            return abort(403, "Your account is disabled, Contact admin");
        }

        // Regenerate session ID after successful login
        $request->session()->regenerate();

        // Redirect to the intended page or homepage with a success message
        return redirect()->intended(route('homepage'))->with('success', "Log In Success!");
    }


    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }
}
