<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'name'                  => $this->name,
            'content'               => strip_tags($this->content),
            'address_on_the_map'    => $this->link_map_address,
            // 'facebook_link'     => $this->facebook_link,
            // 'twitter_link'      => $this->facebook_link,
            // 'instagram_link'    => $this->instagram_link,
            // 'youtube_link'      => $this->youtube_link,
        ];
    }
}
