<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class Task extends Model
{
    use HasFactory;

    /**
     * ONE-TO-MANY
     * One user for several tasks
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ONE-TO-MANY
     * One department for several tasks
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
