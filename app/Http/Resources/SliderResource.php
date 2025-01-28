<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id'    => $this->id,
            'img'   => $this->image_path,
            'type' => pathinfo($this->image_path, PATHINFO_EXTENSION) === 'mp4' ? 'video' : 'photo'
        ];
    }
}
