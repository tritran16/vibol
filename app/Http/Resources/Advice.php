<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Advice extends JsonResource
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
        $data['author'] = $this->author;
        $data['content'] = $this->content;

        $data['type'] = $this->type;
        if ($this->type == 1) {
            $data['image'] = $this->image;
            $data['position'] = $this->position;

        }
        else {
            $data['video'] = $this->video;
        }
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        return $data;

    }
}
