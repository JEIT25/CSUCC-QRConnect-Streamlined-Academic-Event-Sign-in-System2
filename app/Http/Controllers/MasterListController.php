<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MasterList;
use App\Models\User;
use Illuminate\Http\Request;

class MasterListController extends Controller
{

    public function show(Event $event)
    {
        // dd($event->master_list->master_list_students()->with('user')->get());
        return inertia(
            "MasterList/Show",
            [
                "master_list" => $event->master_list,
                "master_list_students" => $event->master_list->master_list_students()->with('user')->get() ?? [], //query master_list_records along with its perspective users , if null return emty array
            ]
        );
    }


    public function store(Request $request, Event $event) //define Event class to recieve the EVent instance that contains the current event
    {
        if (!$event->master_list) { //if it does not return the related model,call it as attribute instead of invoking it as method(master_list())
            $user = $request->user();

            $event->master_list()->create([ //create event,
                //no need specify event_id,since $event variable holds the current event
                "name" => "{$event->name} Master List", // and get name from validation
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

