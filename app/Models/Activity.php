<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'code',
        'name',
        'description',
        'location',
        'start_date',
        'profile_image',
    ];
}
