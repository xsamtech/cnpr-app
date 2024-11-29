<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * MANY-TO-ONE
     * Several users for a department
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * MANY-TO-ONE
     * Several tasks for a department
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * MANY-TO-ONE
     * Several tasks for a department
     */
    public function siblings()
    {
        return $this->hasMany($this, 'belongs_to');
    }
}
