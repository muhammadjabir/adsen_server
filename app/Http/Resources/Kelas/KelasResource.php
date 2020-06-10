<?php

namespace App\Http\Resources\Kelas;

use Illuminate\Http\Resources\Json\ResourceCollection;

class KelasResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'description' => 'Data Kelas Hari Ini',
            'data'=>parent::toArray($request)
            ];
    }
}
