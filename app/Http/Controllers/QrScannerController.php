<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\User;
use Illuminate\Http\Request;

class QrScannerController extends Controller
{

    //this function handles the check in or check out of the user.return a json response
    private function checkInOrOut($event,$user,$type="check_in",$action="check in") { //$type=(check_in/check_out), $action=(checkin/checkout)
        // Check if the user is already checked in for this event
        $existingAttendee = Attendee::where('event_id', $event->id)
            ->where('attendee_id', $user->id)
            ->first();

        if ($existingAttendee) {
            // If already checked in, return a message saying so
            if ($existingAttendee->$type) {
                return response()->json([
                    'message' => "User has already $action for this event",
                    'status' => false,
                    'attendee' => $user,
                    $type => $existingAttendee->$type
                ]);
            } else { //if existing attendee and did not check in yet
                $existingAttendee->update([
                    $type => now(),
                ]);

                return response()->json([
                    'message' => "$action Successfully",
                    'attendee' => $user,
                    'status' => true,
                    $type => $existingAttendee->$type
                ]);

            }
        }

        // Create a new attendee entry for the event with current date/time as check-in
        $newAttendee = $event->attendees()->create([
            "attendee_id" => $user->id,
            $type => now(),
        ]);

        return response()->json([
            'attendee' => User::find($newAttendee->attendee_id),
            'message' => 'Check-in successful',
            'status' => true,
            $type => $newAttendee->$type,
        ]);
    }

    public function checkin(Event $event,Request $request)
    {
        if ($request->user()->cannot('create', [Attendee::class, $event])) { //use policy to check if user can create attendance records,
            //also passed the event so that only owner of event can see create attendance records
            abort(403);
        }
        return inertia('QrScanner/Checkin', [
            "event" => $event,
        ]);
    }

    public function checkinPost(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [Attendee::class, $event])) { //use policy to check if user can create attendance records,
            //also passed the event so that only owner of event can see create attendance records
            abort(403);
        }
        // Validate received QR data
        $validated = $request->validate([
            "qrData" => 'string|required',
        ]);

        // Query to find student using school ID number
        $user = User::where('school_id_number', '=', $validated['qrData'])->first();


        // If user is not found, return an error
        if (!$user) {
            return response()->json(['message' => 'User not found', "status" => false]);
        }
        if($event->is_restricted && $user->type == "student") {
            $student = $event->master_list->master_list_students()->where('user_id', '=', $user->id)->first(); //query if student is in master List student records
            if(!$student) {
                return response()->json([
                    "message" => "Attendance Failed, student not in master list",
                    "status" => false
                ]);
            }
            return $this->checkInOrOut($event, $user, "check_in", "check in");
        } else if(!$event->is_restricted) {
            return $this->checkInOrOut($event, $user, "check_in", "check in");
        } else {
            return response()->json([
                "message" => "Attendance Failed: This event is restricted, and only participants listed in the Master List are allowed to check in",
                "status" => false
            ]);
        }
    }


    public function checkout(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [Attendee::class, $event])) { //use policy to check if user can create attendance records,
            //also passed the event so that only owner of event can see create attendance records
            abort(403);
        }
        return inertia('QrScanner/Checkout', [
            "event" => $event,
        ]);
    }

    public function checkoutPost(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [Attendee::class, $event])) { //use policy to check if user can create attendance records,
            //also passed the event so that only owner of event can see create attendance records
            abort(403);
        }
        // Validate received QR data
        $validated = $request->validate([
            "qrData" => 'string|required',
        ]);

        // Query to find student using school ID number
        $user = User::where('school_id_number', '=', $validated['qrData'])->first();
        // If user is not found, return an error
        if (!$user) {
            return response()->json(['message' => 'User not found', "status" => false]);
        }
        if ($event->is_restricted && $user->type == "student") {
            $student = $event->master_list->master_list_students()->where('user_id', '=', $user->id)->first(); //query if student is in master List
            if (!$student) {
                return response()->json([
                    "message" => "Attendance Failed, student not in master list",
                    "status" => false
                ]);
            }
            return $this->checkInOrOut($event, $user, "check_out", "check out");
        } else if (!$event->is_restricted) {

            return $this->checkInOrOut($event, $user, "check_out", "check out");
        } else {
            return response()->json([
                "message" => "Attendance Failed: This event is restricted, and only participants listed in the Master List are allowed to check out",
                "status" => false
            ]);
        }
    }
}

