<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    protected $table = 'calon_siswa';

    public function kelas_pilihan(){
        return $this->belongsTo('\App\Models\Kelas','kelas');
    }
}
