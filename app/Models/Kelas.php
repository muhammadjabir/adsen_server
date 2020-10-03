<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;
    protected $table ='class';

    protected $appends = ['hari_masuk'];
    protected $dates=['awal_pendaftaran','akhir_pendaftaran','start_class','end_class'];
    public function  getHariMasukAttribute()
    {
        return $this->kelasHasDay()->pluck('description');
    }
    public function kelasHasDay(){
        return $this->belongsToMany('\App\Models\MasterDataDetail','kelas_day','id_kelas','id_hari')->orderBy('id_hari');
    }

    public function courses(){
        return $this->belongsTo('\App\Models\Courses','id_kursus');
    }

    public function trainer(){
        return $this->belongsTo('\App\User','id_trainer');
    }

    public function students(){
        return $this->belongsToMany('\App\Models\Student','students_class','id_kelas','id_student');
    }

    public function absen(){
        return $this->hasMany('\App\Models\Absensi','id_kelas');
    }
}
