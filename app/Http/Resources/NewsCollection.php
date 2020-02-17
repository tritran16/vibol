<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
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
        $lang = $request->header('location','kh');
        foreach ($this->collection as $item) {
            $_news['id'] = $item->id;
            $_news['category'] = ['id' => $item->category->id, 'name' => $item->category->translate($lang)->name];
            $_news['thumbnail'] = url($item->thumbnail);
            $_news['image'] = url($item->image);
            $_news['title'] = $item->translate($lang)->title;
            $_news['short_desc'] = $item->translate($lang)->short_desc;
            $_news['status'] = $item->status;
            $_news['is_hot'] = $item->is_hot;
            $_news['views'] = $item->views;
            $_news['likes'] = $item->likes;
            $_news['created_at'] = $item->created_at;
            $_news['updated_at'] = $item->updated_at;

            $data[] = $_news;
        }
        return [
            'news' => $data,
            'total' => $this->pagination['total'],
            'per_page' => $this->pagination['perPage'],
            'current_page' => $this->pagination['currentPage'],
            'total_pages' => $this->pagination['totalPages'],
        ];
    }
}
