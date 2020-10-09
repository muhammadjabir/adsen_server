<?php

namespace App\Helpers;

use App\Models\LogHistory;

Class Log{

    public static function createLog($deskripsi) {
        $data = new LogHistory;
        $data->ip = \Request::ip();
        $data->deskripsi = $deskripsi;
        $data->id_user = \Auth::user()->id;
        $data->save();
    }
}