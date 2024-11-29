<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class Message extends Model
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
     * One type for several messages
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * ONE-TO-MANY
     * One status for several messages
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * ONE-TO-MANY
     * One user for several messages
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ONE-TO-MANY
     * One addressee_role for several messages
     */
    public function addressee_role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * ONE-TO-MANY
     * One addressee_user for several messages
     */
    public function addressee_user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ONE-TO-MANY
     * One presence_absence for several messages
     */
    public function presence_absence()
    {
        return $this->belongsTo(PresenceAbsence::class);
    }

    /**
     * MANY-TO-ONE
     * Several files for a message
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
