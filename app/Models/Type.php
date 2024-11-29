<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class Type extends Model
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
     * One group for several types
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * MANY-TO-ONE
     * Several messages for a type
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * MANY-TO-ONE
     * Several files for a type
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * MANY-TO-ONE
     * Several histories for a type
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
