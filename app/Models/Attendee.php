<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendee_id',
        'event_id',
        'check_in',
        'check_out'
    ];

    // Relationship with User model (attendee)
    public function user()
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }

    // Relationship with Event model
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
