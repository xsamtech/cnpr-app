<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * MANY-TO-MANY
     * Several branches for several users
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * ONE-TO-MANY
     * One city for several branches
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
