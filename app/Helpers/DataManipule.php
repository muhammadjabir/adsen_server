<?php 
namespace App\Helpers;

class DataManipule{
    
    public static function dataAccount($data) {
        return $datas = [
            'nama' => $data->nama,
            'hari' => $data->kelas_pilihan->hari_masuk,
            'email' => $data->email,
            'start_class' => $data->kelas_pilihan->start_class->format('d-m-Y'),
            'end_class' => $data->kelas_pilihan->end_class->format('d-m-Y'),
            'jam_masuk' => $data->kelas_pilihan->jam_masuk,
            'jam_pulang' => $data->kelas_pilihan->jam_pulang,
            'trainer' => $data->kelas_pilihan->trainer->name
        ];
    }
}