<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    protected $appends = ['foto_profile'];
    public function kelas(){
        return $this->belongsToMany('\App\Models\Kelas','students_class','id_student','id_kelas');
    }
    public function getFotoProfileAttribute(){
        return $this->foto ? asset('storage/' .$this->foto) : asset('storage/defaultprofile.jpg');
    }
    public function user() {
        return $this->belongsTo('\App\User','id_user');
    }
}
