<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MasterList;
use Illuminate\Http\Request;

class MasterListController extends Controller
{

    public function show(Event $event)
    {

        return inertia(
            "MasterList/Show",
            [
                "master_list" => $event->master_list()->first(),
            ]
        );
    }

    public function create(Event $event)
    {
        if (!$event->master_list()->exists()) {
            return inertia(
                'MasterList/Create',
                [
                    'event' => $event //this will be passed to the form template
                    //and when form is submitted laravels route model binding will handle the rest
                ]
            );
        } else {
            return redirect()->route('events.show', ["event" => $event->id])->with("failed", "Master List Already Exist!");
        }
    }

    public function store(Request $request, Event $event) //define Event class to recieve the EVent instance that contains the current event
    {
        if (!$event->master_list) { //if it does not return the related model
            $user = $request->user();
            $validatedData = $request->validate(
                [
                    "name" => "required",
                ]
            );

            $event->master_list()->create([ //create event,
                //no need specify event_id,since $event variable holds the current event
                "name" => $validatedData['name'], // and get name from validation
                "user_id" => $user->id, // specify user_id
            ]);

            $event->update([ //set restricted to true,be used for limiting attendees to the master list
                "is_restricted" => true
            ]);

            return redirect()->route('events.show',["event" => $event->id])->with("success", "Succesfully Created Master List");
        } else {
            return redirect()->route('events.show', ["event" => $event->id])->with("failed", "Master List Already Exist!");
        }

    }


}
