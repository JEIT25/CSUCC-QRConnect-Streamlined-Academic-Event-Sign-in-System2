<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function master_list() : HasOne
    {
        return $this->hasOne(MasterList::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }



    protected $fillable = [
        'code',
        'name',
        'description',
        'location',
        'start_date',
        'profile_image',
        'is_restricted'
    ];
}
