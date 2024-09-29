<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\AttendeeRecord;
use App\Models\MasterListMember;
use App\Models\User;
use Illuminate\Http\Request;

class QrScannerController extends Controller
{

    private function checkInOrOut($event, $member, $type = "check_in", $action = "check in")
    {
        try {
            // Check if the member is already checked in for this event
            $existingAttendeeRecord = AttendeeRecord::where('event_id', $event->event_id)
                ->where('master_list_member_id', $member->master_list_member_id)
                ->first();

            if ($existingAttendeeRecord) {
                // If already checked in, return a message saying so
                if ($existingAttendeeRecord->$type) {
                    return response()->json([
                        'message' => "Member has already $action for this event",
                        'status' => false,
                        'attendee_record' => $member,
                        $type => $existingAttendeeRecord->$type,
                    ]);
                } else { // If existing attendee and did not check in yet
                    $existingAttendeeRecord->update([$type => now()]);
                    return response()->json([
                        'message' => "$action successful",
                        'attendee_record' => $member,
                        'status' => true,
                        $type => $existingAttendeeRecord->$type,
                    ]);
                }
            }

            // Create a new attendee entry for the event with current date/time as check-in
            $newAttendeeRecord = $event->attendee_records()->create([
                "master_list_member_id" => $member->master_list_member_id,
                $type => now(),
            ]);

            return response()->json([
                'attendee_record' => MasterListMember::find($newAttendeeRecord->master_list_member_id),
                'message' => 'Check-in successful',
                'status' => true,
                $type => $newAttendeeRecord->$type,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => false,
            ]);
        }
    }


    public function checkin(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [AttendeeRecord::class, $event])) {
            abort(403);
        }
        return inertia('QrScanner/Checkin', [
            "event" => $event,
        ]);
    }

    public function checkinPost(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [AttendeeRecord::class, $event])) {
            abort(403);
        }

        // Validate received QR data
        $validated = $request->validate([
            "qrData" => 'string|required',
        ]);

        // Query to find member using unique ID
        $member = MasterListMember::where('unique_id', '=', $validated['qrData'])->first();

        // If member is not found, return an error
        if (!$member || $member->event_id !== $event->event_id) {
            return response()->json(['message' => 'Person not found in Master List!', "status" => false]);
        }

        return $this->checkInOrOut($event, $member, "check_in", "check in");
    }

    public function checkout(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [AttendeeRecord::class, $event])) {
            abort(403);
        }
        return inertia('QrScanner/Checkout', [
            "event" => $event,
        ]);
    }

    public function checkoutPost(Event $event, Request $request)
    {
        if ($request->user()->cannot('create', [AttendeeRecord::class, $event])) {
            abort(403);
        }

        // Validate received QR data
        $validated = $request->validate([
            "qrData" => 'string|required',
        ]);

        // Query to find member using unique ID
        $member = MasterListMember::where('unique_id', '=', $validated['qrData'])->first();

        // If member is not found, return an error
        if (!$member || $member->event_id !== $event->event_id) {
            return response()->json(['message' => 'Person not found in Master List!', "status" => false]);
        }

        return $this->checkInOrOut($event, $member, "check_out", "check out");
    }

}

