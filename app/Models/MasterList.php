<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Builder;

class MasterList extends Model
{
    use HasFactory;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event() : BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function master_list_students() : HasMany
    {
        return $this->hasMany(MasterListStudent::class);
    }

    protected $fillable = [
        'name',
        'user_id',
        'event_id'
    ];
}
