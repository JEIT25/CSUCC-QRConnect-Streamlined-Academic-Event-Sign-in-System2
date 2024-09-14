<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
class AttendeeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event,Request $request)
    {
        // Fetch the attendees of the event
        $attendees = $event->attendees()->get();

        if ($request->user()->cannot('viewAny',[Attendee::class,$event])) { //use policy to check if user can viewa attendance records,
        //also passed the event so that only owner of event can see all attendance records of this event
            abort(403);
        }

        return inertia('Attendee/Index', [
            'event' => $event,
            'attendees' => $attendees->load('user') //load each related user for each attendee
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event , Attendee $attendee)
    {
        $attendee->delete();

        return redirect()->route('attendees.index',["event" => $event->id])
        ->with("success","Attendee deleted successfully.");
    }
}
