<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Resources\Json\JsonResource;

class Course extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $datas['videos'] = $this->video()->orderBy('created_at','desc')->paginate(12);
        $datas = array_merge($data,$datas);
        return $datas;
    }
}
