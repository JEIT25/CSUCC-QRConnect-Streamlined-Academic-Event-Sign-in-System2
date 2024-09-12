<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MasterList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterListStudentController extends Controller
{
    public function store(Event $event, MasterList $master_list, Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
        ]);

        // Extract first and last name
        $fname = $validated['fname'];
        $lname = $validated['lname'];

        // Query the User table to find the student with the matching first and last name
        $user = User::where('fname', '=', $fname)
            ->where('lname', '=', $lname)
            ->where("type","student")
            ->first();

        // If no matching user is found, return an error
        if (!$user) {
            return back()->with('failed','Student not found.');
        }

        // Add the user to the master list for the event
        $event->master_list->master_list_students()->create([
            "user_id" => $user->id
        ]);

        return back()->with('success', 'Student added successfully to the master list.');
    }

}
