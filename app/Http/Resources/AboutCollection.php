<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AboutCollection extends ResourceCollection
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
        $data = [];
        foreach ($this->collection as $item) {
            $_item = [];
            $_item['id'] = $item->id;
            $_item['image'] = isset( $item->image)? url( $item->image): '';
            $_item['video_link'] = $item->video_link;
            $_item['content'] = $item->content;
            $data[] = $_item;
        }
        return [
            'about' => $data,
            'total' => $this->pagination['total'],
            'per_page' => $this->pagination['perPage'],
            'current_page' => $this->pagination['currentPage'],
            'total_pages' => $this->pagination['totalPages'],
        ];
        // return parent::toArray($request);
    }
}
