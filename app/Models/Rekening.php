<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table='rekening';
    protected $appends = ['foto_rekening'];
    public function getFotoRekeningAttribute(){
        return asset('storage/' .$this->foto) ;
    }
}
