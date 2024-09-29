<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MasterListMember extends Model
{
    use HasFactory;
    protected $primaryKey = 'master_list_member_id';
    protected $fillable = ['master_list_id', 'full_name', 'unique_id'];

    public function master_list(): BelongsTo
    {
        return $this->belongsTo(MasterList::class, 'master_list_id');
    }

    public function attendee_record(): HasOne
    {
        return $this->hasOne(AttendeeRecord::class, "master_list_member_id");
    }

}
