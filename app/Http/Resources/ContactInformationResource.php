<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactInformationResource extends JsonResource
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
            'phone'                 => $this->phone,
            'email'                 => $this->email,
            'address'               => $this->address,
            'address_on_the_map'    => $this->link_map_address,
            'facebook'              => $this->facebook,
            'twitter'               => $this->twitter,
            'instagram'             => $this->instagram,
            'snapchat'              => $this->snapchat,
            'whatsapp_number'       => $this->whatsapp,
            'whatsapp_link'         => $this->whatsapp ? 'https://wa.me/https://wa.me/' . $this->whatsapp : null,
            'youtube'               => $this->youtube,
        ];
    }
}
