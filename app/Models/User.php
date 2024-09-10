<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function eventsAttended()
    {
        return $this->hasMany(Attendee::class, 'attendee_id');
    }


    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function master_lists():HasMany
    {
        return $this->hasMany(MasterList::class);
    }

        public function master_list_students () : HasMany
    {
        return $this->HasMany(MasterListStudent::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'lname',
        'fname',
        'school_id_number',
        'birth_date',
        'email',
        'password',
        'program',
        'valid_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
