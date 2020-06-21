<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdviceCollection extends ResourceCollection
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
            $_item['type'] = $item->type;
            $_item['image'] = isset($item->image) ? url($item->image) : null;
            if ($item->type == 1) {

                $_item['text_position'] = $item->text_position;
                $_item['content'] = $item->advice;
            }
            else {
                $_item['video'] = isset($item->video) ? url($item->video) : null;
            }
            $_item['likes'] = $item->likes;
            $_item['like'] = isset($item->like_advice_id) ? 1 : 0;

            $data[] = $_item;
        }
        return [
            'advices' => $data,
            'total' => $this->pagination['total'],
            'per_page' => $this->pagination['perPage'],
            'current_page' => $this->pagination['currentPage'],
            'total_pages' => $this->pagination['totalPages'],
        ];
        // return parent::toArray($request);
    }
}
