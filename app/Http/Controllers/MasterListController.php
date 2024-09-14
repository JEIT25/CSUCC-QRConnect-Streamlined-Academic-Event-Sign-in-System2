<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MasterList;
use App\Models\User;
use Illuminate\Http\Request;

class MasterListController extends Controller
{

    public function show(Event $event, MasterList $master_list,Request $request)
    {
        if ($request->user()->cannot('view', [Masterlist::class, $master_list])) { //check if user can create masterlist for this event
            abort(403); //only owner of master_list can view the masterlist
        }
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
        if ($request->user()->cannot('create', [Masterlist::class,$event])) { //check if user can create masterlist for this event
            abort(403); //only owner of event can create the masterlist
        }
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

            return redirect()->route('events.show', ["event" => $event->id])->with("success", "Succesfully Created Master List");
        } else {
            return redirect()->route('events.show', ["event" => $event->id])->with("failed", "Master List Already Exist!");
        }

    }

    public function destroy( Event $event,MasterList $master_list,) //define Event class to recieve the EVent instance that contains the current event
    {
        $event->update([
            "is_restricted" => false
        ]);

       $master_list->delete();


        // Redirect back with a success message
        return redirect()->route('events.show', [
            'event' => $event->id,
        ])->with('success', "Master List for $event->name successfully deleted.");

    }
}

