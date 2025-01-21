<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'title'         => $this->title,
            'img'           => 'https://img.youtube.com/vi/' . get_youtube_id($this->url) . '/hqdefault.jpg',
            'video_url'     => get_youtube_id($this->url),
            'created_at'    => $this->created_at,
            'section'       => new VideoSectionResource($this->video_section),
        ];
    }
}
