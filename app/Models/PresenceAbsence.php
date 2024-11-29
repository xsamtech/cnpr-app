<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class PresenceAbsence extends Model
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
     * One user for several presence_absences
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ONE-TO-MANY
     * One status for several presence_absences
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * MANY-TO-ONE
     * Several messages for a presence_absence
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
