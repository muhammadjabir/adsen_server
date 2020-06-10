<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use SoftDeletes;
    protected $table = 'courses';

    protected $appends = ['foto_courses'];
    public function category(){
        return $this->belongsTo('App\Models\MasterDataDetail','id_category');
    }

    public function getFotoCoursesAttribute(){
        return asset('storage/' .$this->foto) ;
    }
}
