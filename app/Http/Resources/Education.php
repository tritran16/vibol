<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Education extends JsonResource
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

        $data['name'] = $this->name;
        $data['image'] = $this->image ? url($this->image) : '';
        $data['link'] = $this->video_link;
        return $data;

    }
}
