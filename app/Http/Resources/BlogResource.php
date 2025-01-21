<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'img'           => $this->image_path,
            'content'       => $this->content,
            'created_at'    => $this->created_at,
            'section'       => new BlogSectionResource($this->blog_section),
        ];
    }
}
