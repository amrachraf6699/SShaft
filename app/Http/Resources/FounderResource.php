<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FounderResource extends JsonResource
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
            'id'        => $this->id,
            'adjective' => $this->adjective,
            'name'      => $this->name,
            'status'    => $this->status === 'deceased' ? '((رحمه الله))' : null,
            'img'       => $this->image_path,
        ];
    }
}
