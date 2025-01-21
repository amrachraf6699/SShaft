<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'id'             => $this->id,
            'title'          => $this->title,
            'desc'           => $this->desc,
            'cover'          => $this->cover_path,
            'image'          => $this->image_path,
            'services_count' => $this->services->count(),
            'type'           => $this->type(),
            'sub_sections'   => sizeof($this->children()) >= 1 ? $this->children() : null,
            'services'       => SectionWithServicesResource::collection($this->whenLoaded('services')->where('status', 'active')),
        ];
    }
}
