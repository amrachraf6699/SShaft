<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
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
            'id'            => $this->id,
            'membership_no' => $this->membership_no,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'ident_num'     => $this->ident_num,
            'name'          => $this->name,
            'gender'        => $this->gender,
            'status'        => $this->status,
        ];;
    }
}
