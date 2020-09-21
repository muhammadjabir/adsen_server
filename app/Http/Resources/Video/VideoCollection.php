<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $course;
    public function courses($course) {
        $this->course = $course;
    }
    public function toArray($request)
    {
        return [
            'course' => $this->course,
            'videos' =>parent::toArray($request)];
    }
}
