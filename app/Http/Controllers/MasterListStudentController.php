<?php

namespace App\Http\Controllers;

use App\Models\MasterList;
use App\Models\MasterListStudent;
use App\Models\User;
use Illuminate\Http\Request;

class MasterListStudentController extends Controller
{
    public function store(MasterList $master_list, Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
        ]);

        // Extract first and last name from validated data
        $fname = $validated['fname'];
        $lname = $validated['lname'];

        // Query the User table to find the student with the matching first and last name
        $user = User::where('lname', '=', $lname)
            ->where('fname', '=', $fname)
            ->where('type', '=', 'student') // Make sure the user is a student
            ->first();

        // If no matching user is found, return an error
        if (!$user) {
            return back()->with('failed', 'Student not found.');
        }

        // Check if the student is already added to the master list
        if ($master_list->master_list_students()->where('user_id', $user->id)->exists()) {
            return back()->with('failed', 'Student is already in the master list.');
        }

        // Add the student to the master list by creating a new record in master_list_students
        $master_list->master_list_students()->create([
            'user_id' => $user->id,
            'master_list_id' => $master_list,
        ]);

        return back()->with('success', 'Student added successfully to the master list.');
    }

    public function destroy(MasterListStudent $master_list_student)
    {
        // Delete the specific pivot table entry
        $master_list_student->delete();

        // Redirect back with a success message
        return redirect()->route('master-lists.show', [
            'event' => $master_list_student->master_list->event->id,
            'master_list' => $master_list_student->master_list->id,
        ])->with('success', 'Student successfully deleted from the master list.');
    }

}