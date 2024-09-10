<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class FacilitatorController extends Controller
{
    /**
     * Display a listing of the resource (Home Page for authenticated facilitator).
     */
    public function index()
    {
        return Inertia::render('Facilitators/Home', [
            'facilitator' => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new facilitator account.
     */
    public function create()
    {
        return Inertia::render('Facilitator/Create');
    }

    /**
     * Store a newly created facilitator account in storage.
     */
    public function store(Request $request)
    {
        // Validate the request first
        $validated = $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'school_id_number' => 'nullable|string|unique:users',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Create the user
        User::create([
            'type' => 'facilitator', //type to facilitator
            'lname' => $validated['lname'],
            'fname' => $validated['fname'],
            'school_id_number' => $validated['school_id_number'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'program' => null,  // Default to null for user type facilitator
            'valid_id' => null // Default to null for user type facilitator
        ]);

        return redirect()->route('homepage')->with('success', 'Facilitator account created successfully.');
    }


    /**
     * Display the specified facilitator.
     */
    public function show(User $facilitator)
    {
        return Inertia::render('Facilitators/Show', [
            'facilitator' => $facilitator,
        ]);
    }

    /**
     * Show the form for editing the specified facilitator.
     */
    public function edit(User $facilitator)
    {
        return Inertia::render('Facilitators/Edit', [
            'facilitator' => $facilitator,
        ]);
    }

    /**
     * Update the specified facilitator in storage.
     */
    public function update(Request $request, User $facilitator)
    {
        $validated = $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'school_id_number' => 'nullable|string|unique:users,school_id_number,' . $facilitator->id,
            'program' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users,email,' . $facilitator->id,
            'password' => 'nullable|string|min:8|confirmed',
            'valid_id' => 'nullable|string',
        ]);

        $facilitator->update([
            'lname' => $validated['lname'],
            'fname' => $validated['fname'],
            'school_id_number' => $validated['school_id_number'],
            'program' => $validated['program'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $facilitator->password,
            'valid_id' => $validated['valid_id'],
        ]);

        return redirect()->route('facilitators.index')->with('success', 'Facilitator account updated successfully.');
    }

    /**
     * Remove the specified facilitator from storage.
     */
    public function destroy(User $facilitator)
    {
        $facilitator->delete();

        return redirect()->route('facilitators.index')->with('success', 'Facilitator account deleted successfully.');
    }
}
