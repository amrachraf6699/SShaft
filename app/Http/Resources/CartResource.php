<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'id'                => $this->id,
            'donor_id'          => $this->donor_id,
            'service_id'        => $this->service_id,
            'service_title'     => $this->service->title,
            'service_section'   => $this->service->service_section->title,
            'quantity'          => $this->quantity,
            'amount'            => $this->amount,
            'subtotal'          => $this->amount * $this->quantity,
            'created_at'        => $this->created_at,
            'img'               => $this->service->image_path,
        ];
    }
}
