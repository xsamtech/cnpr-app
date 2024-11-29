<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class City extends Model
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
     * One province for several cities
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * MANY-TO-ONE
     * Several branches for a city
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
