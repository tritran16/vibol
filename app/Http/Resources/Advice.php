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
//        $data['author'] = $this->author;


        $data['type'] = $this->type;
        if ($this->type == 1) {
            $data['image'] = url($this->image);
            $data['text_position'] = $this->text_position;
            $data['content'] = $this->advice;

        }
        else {
            $data['video'] = $this->video;
        }
        //$data['status'] = $this->status;
        //$data['created_at'] = $this->created_at;
        //$data['updated_at'] = $this->updated_at;
        $data['likes'] = $this->likes;
        $data['lịke'] = isset($this->like) ? $this->like : 0;
        return $data;

    }
}
