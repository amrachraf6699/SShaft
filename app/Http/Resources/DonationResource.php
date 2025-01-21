<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'id'                    => $this->id,
            'donation_code'         => $this->donation_code,
            'donor_id'              => $this->donor_id,
            'donor_membership_no'   => $this->donor->membership_no,
            'donor_phone'           => $this->donor->phone ?? null,
            'donor_email'           => $this->donor->email ?? null,
            'donor_name'            => $this->donor->name ?? null,
            'total_amount'          => $this->total_amount,
            'services'              => $this->services->count() > 0 ? DonationServicesResource::collection($this->services) : null,
            'donation_status'       => __('translation.' . $this->status),
            'payment_ways'          => $this->payment_ways === 'bank_transfer' ? __('translation.' . $this->payment_ways) : $this->payment_brand,
            'donation_type'         => __('translation.' . $this->donation_type),
            'sender_name'           => $this->gift->sender_name ?? null,
            'sender_phone'          => $this->gift->sender_phone ?? null,
            'recipient_name'        => $this->gift->recipient_name ?? null,
            'recipient_phone'       => $this->gift->recipient_phone ?? null,
            'gift_id'               => $this->gift_id,
            'created_at'            => $this->created_at,
            'qr_code'               => "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . route('donation-invoice.show', $this->donation_code),
        ];
    }
}
