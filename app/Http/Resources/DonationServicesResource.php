<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationServicesResource extends JsonResource
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
            'service_id'    => $this->id,
            'title'         => $this->title,
            'quantity'      => $this->pivot->quantity,
            'amount'        => $this->pivot->amount,
        ];
    }
}
