<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $data = [];
        foreach ($this->collection as $item) {
            $_news['id'] = $item->id;
            $_news['category'] = ['id' => $item->category_id, 'name' => $item->category_name];
            $_news['thumbnail'] = $item->thumbnail?url($item->thumbnail):'';
            $_news['image'] = $item->image?url($item->image):'';
            $_news['title'] = $item->title;
            $_news['short_desc'] = $item->short_desc;
            $_news['video_link'] = $item->video_link;
            $_news['status'] = $item->status;
            $_news['is_hot'] = $item->is_hot;
            $_news['views'] = $item->views;
            $_news['likes'] = $item->likes;
            $_news['is_like'] = isset($item->like_news_id)?1:0;
            $_news['created_at'] = Carbon::parse($item->created_at)->format('d/m/Y');
            $_news['updated_at'] =  Carbon::parse($item->updated_at)->format('d/m/Y');

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
