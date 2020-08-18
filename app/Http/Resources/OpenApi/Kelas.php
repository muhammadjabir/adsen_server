<?php

namespace App\Http\Resources\OpenApi;

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
        return [  'name' => $this->name,
        'slug' => $this->slug,
        'harga' => number_format($this->harga,0),
        'diskon' => $this->diskon,
        'total_harga' => $this->harga - ($this->harga * ($this->diskon/100))
        ];
    }
}
