<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Event/Index',
            [
                'events' => Activity::where('type', 'event')->latest()->get()
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
            [
                'events' => Activity::where('type','event')->latest()->get()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'type' => 'required',
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

            // Add the image path to the validated data before creating the Activity
            $validatedData['profile_image'] = $imagePath;
        }

        // Create a new Activity with the validated data
        Activity::create($validatedData);

        switch($request->type) {
            case 'event':
                return redirect()->route('activities.index')
                    ->with('success', 'SUCCESS!');

            // case 'subject':
            //     return redirect()->route('event.index')
            //         ->with('success', 'SUCCESS!');

            // case 'monitoring':
            //     return redirect()->route('event.index')
            //         ->with('success', 'SUCCESS!');
        };
    }


    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
       if($activity->profile_image) {
            $activity->profile_image = asset("storage/$activity->profile_image"); //using the asset() set profile image path to public path
       }
        return inertia(
            'Event/Show',
            [
                'event' => $activity,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
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
    public function destroy(string $id)
    {
        //
    }
}
