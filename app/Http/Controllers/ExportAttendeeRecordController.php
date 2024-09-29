<?php

namespace App\Http\Controllers;

use App\Models\AttendeeRecord;
use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportAttendeeRecordController extends Controller
{
    public function exportAttendeeRecords(Event $event, $template)
    {
        if($template == "class-orientation") {
            // Fetch attendee records for the given event where both checkin and checkout are not null
            $attendee_records = $event->attendee_records()
                ->whereNotNull('check_in')
                ->whereNotNull('check_out')
                ->get();


            if(count($attendee_records->toArray()) < 1) { //check if there attendees that have checkin and out
                return redirect()->back()->with('failed', "No Attendees found yet");
            }

            // Number of records per page (Pagination setting for PDF)
            $itemsPerPage = 25;

            // Load the view and pass data to it (e.g., attendees who checked in and out)
            $pdf = Pdf::loadView('pdf_templates/class_orientation', [
                'event' => $event,
                'attendee_records' => $attendee_records->load('master_list_member'),
                'facilitator' => $event->owner,
                'itemsPerPage' => $itemsPerPage,
            ]);

            // Return the generated PDF as a download or inline view
            return $pdf->stream(filename: $event->name."_class_orientation_attendance_list.pdf");
        }

    }
}

