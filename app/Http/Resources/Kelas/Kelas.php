<?php

namespace App\Http\Resources\Kelas;

use Illuminate\Http\Resources\Json\JsonResource;

class Kelas extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_absen = $this->absen()->orderBy('created_at','desc')->first();
        $parent = ['id' => $this->id,
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'jam_masuk' => $this->jam_masuk,
                    'jam_pulang' => $this->jam_pulang,
                    'hari_masuk' => $this->hari_masuk];
        $data['trainer'] = [
            'name' => $this->trainer->name,
            'foto_trainer' => $this->trainer->foto_profile,
        ];
        $data['courses'] = [
            'name' =>$this->courses->name,
            'foto_courses' => $this->courses->foto_courses,
        ];
        $data['total_hadir'] = $total_absen ? count($total_absen->id_siswa) : 0;

        $data = array_merge($parent,$data);

        return [
            'description' => 'Data Class',
            'data' => $data
        ];
    }
}
