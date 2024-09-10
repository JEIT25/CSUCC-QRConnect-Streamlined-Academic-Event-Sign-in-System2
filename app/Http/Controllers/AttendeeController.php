<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    // public function index(Request $request,Event $event)
    // {
    //     // Retrieve all attendees associated with the event_attendee records for the specified event_id
    //     $attendees = Attendee::whereHas('eventAttendees', function ($query) use ($request) {
    //         $query->where('event_id', $request->query('event_id'));
    //     })->with('eventAttendees')->get();

    //     return view('event-attendees.index', ['attendees' => $attendees]);
    // }
}
