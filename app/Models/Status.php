<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * ONE-TO-MANY
     * One group for several statuses
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * MANY-TO-ONE
     * Several users for a status
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * MANY-TO-ONE
     * Several messages for a status
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * MANY-TO-ONE
     * Several presence_absences for a status
     */
    public function presence_absences()
    {
        return $this->hasMany(PresenceAbsence::class);
    }

    /**
     * MANY-TO-ONE
     * Several notifications for a status
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
