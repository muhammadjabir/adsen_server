<?php

namespace App\Http\Resources\Kelas;

use Illuminate\Http\Resources\Json\ResourceCollection;

class KelasCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
