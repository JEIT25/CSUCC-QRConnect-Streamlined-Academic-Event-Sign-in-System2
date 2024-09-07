<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Event/Index',
            [
                'events' => Event::where("is_restricted","=","false")->latest()->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia(
            'Event/Create',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user(); //get current user that inside request
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required|date',
            'profile_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:5000'  // Validate image type and size
        ], [
            'profile_image.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
        ]);

        // Handle the profile image if it's present
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imagePath = $profileImage->store('images/events', 'public');  // Store the image in the 'images' directory in the 'public' disk

            // Add the image path to the validated data before creating the Event
            $validatedData['profile_image'] = $imagePath;
        }

        // Create a new Event with the validated data
        $user->events()->create($validatedData);

        return redirect()->route('events.index')
            ->with('success', 'SUCCESS!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        if ($event->profile_image) {
            $event->profile_image = asset("storage/$event->profile_image"); //using the asset() set profile image path to public path
        }

        $master_list = $event->master_list()->first();


        return inertia(
            'Event/Show',
            [
                'event' => $event,
                'master_list' => $master_list
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return inertia(
            'Event/Edit',
            [
                "event" => $event
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required|date',
            'profile_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:5000',  // Validate image type and size
        ], [
            'profile_image.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
        ]);


        // Handle the profile image if it's present
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($event->profile_image) {
                Storage::disk('public')->delete($event->profile_image);
            }

            // Store the new profile image
            $profileImage = $request->file('profile_image');
            $imagePath = $profileImage->store('images/events', 'public');  // Store the image in the 'images' directory in the 'public' disk

            // Add the new image path to the validated data
            $validatedData['profile_image'] = $imagePath;
        }

        // Update the existing Event with the validated data
        $event->update($validatedData);
        return redirect()->route('events.show', ['event' => $event->id])
            ->with('success', 'SUCCESS!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->profile_image);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'SUCCESSFULLY DELETED!');
    }
}
