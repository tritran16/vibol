<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PoetryCollection extends ResourceCollection
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
        if ($this->collection) {
            foreach ($this->collection as $item) {
                $poetry['id'] = $item->id;
                 $poetry['thumbnail'] = isset($item->thumbnail) ? url($item->thumbnail) : null;
                $poetry['title'] = $item->title;
                $poetry['content'] = $item->content;
                $poetry['status'] = $item->status;
                $poetry['video_link'] = $item->video_link;
                $poetry['author'] = $item->author;
                $poetry['source'] = $item->source;
                $poetry['is_hot'] = $item->is_hot;
                $poetry['views'] = $item->views;
                $poetry['likes'] = $item->likes;
                $poetry['is_like'] = isset($item->like_poetry_id) ? 1 : 0;
                $poetry['created_at'] =  Carbon::parse($item->created_at)->format('d/m/Y');
                $poetry['updated_at'] =  Carbon::parse($item->updated_at)->format('d/m/Y');

                $data[] = $poetry;
            }
            return [
                'poetrys' => $data,
                'total' => $this->pagination['total'],
                'per_page' => $this->pagination['perPage'],
                'current_page' => $this->pagination['currentPage'],
                'total_pages' => $this->pagination['totalPages'],
            ];
        }
        return  [];
        // return parent::toArray($request);
    }
}
