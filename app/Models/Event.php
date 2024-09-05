<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
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
