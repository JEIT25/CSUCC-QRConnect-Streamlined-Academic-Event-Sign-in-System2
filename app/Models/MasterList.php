<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterList extends Model
{
    use HasFactory;
    

    public function master_list() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'name',
        'user_id',
        'event_id'
    ];
}
