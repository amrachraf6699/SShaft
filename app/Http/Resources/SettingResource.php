<?php

namespace App\Http\Resources;

use App\Branch;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $branch = Branch::where('id', request()->branch_id)->first();
        $nearpay = json_decode(request()->branch_id && $branch ? $branch->nearpay : $this->nearpay);
        $nearpay->enableReceiptUi = $nearpay->enableReceiptUi && $nearpay->enableReceiptUi == true ? true : false;

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
            'whatsapp_link'         => $this->whatsapp ? 'https://wa.me/' . $this->whatsapp : null,
            'youtube'               => $this->youtube,
            'logo'                  => $this->logo_path,
            'name'                  => $this->name,
            'description'           => $this->description,
            'aboutApp'              => $this->aboutApp,
            'appname'               => $this->appname,
            'keywords'              => $this->keywords,
            'debugMode'             => $this->debugMode,
            'aboutAppHead'          => $this->aboutAppHead,
            'aboutAppFoot'          => $this->aboutAppFoot,
            'sms_token'             => $this->sms_token,
            'sms_sender'            => $this->sms_sender,
            'paymentGateWay'        => (request()->branch_id && $branch && $branch->paymentGateWay) ? $branch->paymentGateWay : $this->paymentGateWay,
            'is_refresh'            => (request()->branch_id && $branch && $branch->is_refresh) ? true : false,
            'refresh_time'          => (request()->branch_id && $branch && $branch->refresh_time) ? $branch->refresh_time : $this->refresh_time,
            'pinned_mode'           => (request()->branch_id && $branch && $branch->pinned_mode) ? true : false,
            'quick_donations'       => (request()->branch_id && $branch && $branch->quick_donations) ? true : false,
            'nearpay'               => $nearpay,

        ];
    }
}
