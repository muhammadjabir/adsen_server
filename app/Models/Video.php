<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    // protected $appends=['video'];
    // public function getVideoAttribute($value)
    // {
    //     return asset('storage/' . $this->attributes['video']);
    // }
    public function courses() {
        return $this->belongsTo('App\Models\Courses','id_courses');
    }
}
