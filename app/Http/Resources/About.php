<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class About extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if (!$this->resource) {
            return [];
        }
        $data['id'] = $this->id;

        $data['content'] = $this->content;
        $data['image'] = $this->image;
        $data['video_link'] = $this->video_link;
        $data['likes'] = $this->likes;
        return $data;

    }
}
