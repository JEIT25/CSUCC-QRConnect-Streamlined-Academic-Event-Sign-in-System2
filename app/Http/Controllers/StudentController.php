<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function create()
    {
        return inertia('Student/Create');
    }

    public function store(Request $request)
    {
        // Validate the request first
        $validated = $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'school_id_number' => 'required|string|unique:users',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $student = User::create([
            'type' => 'student', //type to program
            'lname' => $validated['lname'],
            'fname' => $validated['fname'],
            'school_id_number' => $validated['school_id_number'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'program' => $request->program,
            'valid_id' => null // Default to null for user type student
        ]);

        return redirect()->route('qr-generator.show',['user' => $student])->with('success', 'Student account created successfully.');
    }
}
