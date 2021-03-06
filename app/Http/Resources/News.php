<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class News extends JsonResource
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
        $lang = $request->header('location','kh');
        $data['id'] = $this->id;
        $data['category'] =  ['id' => $this->category_id, 'name' => $this->category->translate($lang)->name ];
        $data['status'] =  $this->status;
        $data['title'] =  $this->translate($lang)->title;
        $data['short_desc'] =  $this->translate($lang)->short_desc;
        $data['content'] =  $this->translate($lang)->content;
        $data['image'] =  isset($this->image)?url($this->image):null;
        $data['thumbnail'] =  isset($this->thumbnail)?url($this->thumbnail):null;
        $data['author'] =  $this->author;
        $data['source'] =  $this->source;
        $data['created_at'] =  $this->created_at;
        $data['views'] =  $this->views;
        $data['likes'] =  $this->likes;
        $data['is_hot'] = $this->is_hot;
        return $data;//parent::toArray($request);
    }
}
