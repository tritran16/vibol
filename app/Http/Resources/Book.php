<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
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
        $data['category'] =  ['id' => $this->category->id, 'name' => $this->category->name ];
        $data['status'] =  $this->status;
        $data['name'] =  $this->name;
        $data['description'] =  $this->description;
        $data['thumbnail'] =  url($this->thumbnail);
        $data['link'] =  $this->link;
        $data['page_number'] =  $this->page_number;
        $data['author'] =  $this->author;
        $data['source'] =  $this->source;
        $data['views'] =  $this->views;
        $data['likes'] =  $this->likes;
        $data['is_hot'] = $this->is_hot;
        $data['created_at'] =  $this->created_at;
        $data['updated_at'] =  $this->updated_at;
        return  $data;
        //return parent::toArray($request);
    }
}
