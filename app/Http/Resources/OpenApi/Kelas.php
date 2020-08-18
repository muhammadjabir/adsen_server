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
        'harga' => number_format($this->courses->harga,0),
        'diskon' => $this->courses->diskon,
        'total_harga' => $this->courses->harga - ($this->courses->harga * ($this->courses->diskon/100))
        ];
    }
}
