<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id'                        => $this->id,
            'title'                     => $this->title,
            'cover'                     => $this->cover_path,
            'img'                       => $this->image_path,
            'icon'                      => $this->icon_app,
            'how_does_the_service_work' => strip_tags($this->how_does_the_service_work),
            'content'                   => strip_tags($this->content),
            'price_value'               => $this->price_value,
            'basic_service_value'       => $this->basic_service_value,
            'multiple_service_value_1'  => $this->multiple_service_value_1,
            'multiple_service_value_2'  => $this->multiple_service_value_2,
            'multiple_service_value_3'  => $this->multiple_service_value_3,
            'target_value'              => $this->target_value,
            'collected_value'           => $this->collected_value,
            'percent'                   => $this->percent,
            'viewpercent'              => $this->viewpercent,
            'section'                   => new SectionResource($this->service_section),
        ];
    }
}
