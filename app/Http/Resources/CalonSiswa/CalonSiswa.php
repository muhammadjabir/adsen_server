<?php

namespace App\Http\Resources\CalonSiswa;

use Illuminate\Http\Resources\Json\JsonResource;

class CalonSiswa extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'nama' => $this->nama,
            'email' => $this->email,
            'nohp' => $this->nohp,
            'nowa' => $this->nowa,
            'status' => $this->status == 'Mahasiswa' ? 'Mahasiswa/Pelajar' :$this->status,
            'kelas' => $this->kelas_pilihan->name,
            'catatan' => $this->catatan,
            'status_pendaftaran' => $this->status_pendaftaran
        ];
    }
}
