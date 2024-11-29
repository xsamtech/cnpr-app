<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * MANY-TO-MANY
     * Several users for several roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * MANY-TO-MANY
     * Several users for several branches
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    /**
     * ONE-TO-MANY
     * One status for several users
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * ONE-TO-MANY
     * One department for several users
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * MANY-TO-ONE
     * Several presence_absences for a user
     */
    public function presence_absences()
    {
        return $this->hasMany(PresenceAbsence::class);
    }

    /**
     * MANY-TO-ONE
     * Several paid_unpaids for a user
     */
    public function paid_unpaids()
    {
        return $this->hasMany(PaidUnpaid::class);
    }

    /**
     * MANY-TO-ONE
     * Several tasks for a user
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * MANY-TO-ONE
     * Several messages for a user
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * MANY-TO-ONE
     * Several histories for a user
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }

    /**
     * MANY-TO-ONE
     * Several notifications for a user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * MANY-TO-ONE
     * Several sessions for a user
     */
    public function sessions()
    {
        return $this->hasMany(Notification::class);
    }
}
