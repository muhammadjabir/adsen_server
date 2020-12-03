<?php

namespace App\Http\Resources\Lokers;

use Illuminate\Http\Resources\Json\JsonResource;

class Lokers extends JsonResource
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
            'judul' => $this->judul,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
            'foto' => asset('storage/' .$this->foto)
        ];
    }
}
