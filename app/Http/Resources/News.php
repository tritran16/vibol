<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $data['video_link'] =  $this->video_link;
        $data['author'] =  $this->author;
        $data['source'] =  $this->source;
        $data['created_at'] =  Carbon::parse($this->created_at)->format('d/m/Y');
        $data['updated_at'] =  Carbon::parse($this->updated_at)->format('d/m/Y');
        $data['views'] =  $this->views;
        $data['likes'] =  $this->likes;
        $data['is_hot'] = $this->is_hot;
        $data['is_like'] = isset($this->is_like)?$this->is_like:0;
        return $data;//parent::toArray($request);
    }
}
