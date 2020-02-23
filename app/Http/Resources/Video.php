<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Video extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['category'] =  ['id' => $this->category->id, 'name' => $this->category->name ];
        $data['status'] =  $this->status;
        $data['title'] =  $this->title;
        $data['description'] =  $this->description;
        $data['thumbnail'] =  isset($this->thumbnail)?url($this->thumbnail):null;
        $data['link'] =  $this->link;
        $data['author'] =  $this->author;
        $data['source'] =  $this->source;
        $data['views'] =  $this->views;
        $data['likes'] =  $this->likes;
        $data['is_hot'] = $this->is_hot;
        $data['created_at'] =  Carbon::parse($this->created_at)->format('d/m/Y');
        $data['updated_at'] =  Carbon::parse($this->updated_at)->format('d/m/Y');
        $data['is_like'] = isset($this->is_like)?$this->is_like:0;
        return $data; //parent::toArray($request);
    }
}
