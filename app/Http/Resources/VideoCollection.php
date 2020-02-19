<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoCollection extends ResourceCollection
{
    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'perPage' => $resource->perPage(),
            'currentPage' => $resource->currentPage(),
            'totalPages' => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->collection as $item) {
            $video['id'] = $item->id;
            $video['category'] = ['id' => $item->category->id, 'name' => $item->category->name];
            $video['thumbnail'] = $this->thumbnail?url($item->thumbnail):null;
            $video['title'] = $item->title;
            $video['description'] = $item->description;
            $video['status'] = $item->status;
            $video['link'] = $item->link;
            $video['author'] = $item->author;
            $video['source'] = $item->source;
            $video['is_hot'] = $item->is_hot;
            $video['views'] = $item->views;
            $video['likes'] = $item->likes;
            $video['created_at'] = $item->created_at;
            $video['updated_at'] = $item->updated_at;

            $data[] = $video;
        }
        return [
            'videos' => $data,
            'total' => $this->pagination['total'],
            'per_page' => $this->pagination['perPage'],
            'current_page' => $this->pagination['currentPage'],
            'total_pages' => $this->pagination['totalPages'],
        ];
        // return parent::toArray($request);
    }
}
