<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\User;
use Illuminate\Http\Request;

class QrScannerController extends Controller
{
    public function checkin(Event $event)
    {
        return inertia('QrScanner/Checkin', [
            "event" => $event,
        ]);
    }

    public function checkinPost(Event $event, Request $request)
    {
        // Validate received QR data
        $validated = $request->validate([
            "qrData" => 'string|required',
        ]);

        // Query to find student using school ID number
        $user = User::where('school_id_number', '=', $validated['qrData'])->first();
        // If user is not found, return an error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the user is already checked in for this event
        $existingAttendee = $event->attendees()->where('attendee_id', $user->id)->first();

        if ($existingAttendee) {
            // If already checked in, return a message saying so
            if ($existingAttendee->check_in) {
                return response()->json([
                    'message' => 'User has already checked in for this event',
                    'attendee' => $existingAttendee->user->first(),
                    'check_in' => $existingAttendee->check_in
                ]);
            }
        }

        // Create a new attendee entry for the event with current date/time as check-in
        $newAtttendee = $event->attendees()->create([
            "attendee_id" => $user->id,
            'check_in' => now(),
        ]);

        return response()->json([
            'attendee' => $newAtttendee->user->first(),
            'message' => 'Check-in successful',
            'check_in' => now(),
        ]);
    }

}

