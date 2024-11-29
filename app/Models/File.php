<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class File extends Model
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
     * One type for several files
     */
    public function type()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * ONE-TO-MANY
     * One message for several files
     */
    public function message()
    {
        return $this->belongsTo(File::class);
    }
}
