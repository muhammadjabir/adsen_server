<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{

    protected $table = 'absensi';

    protected $appends = ['id_siswa'];

    public function  getIdSiswaAttribute()
    {
        return json_decode($this->attributes['id_siswa']);
    }
}
