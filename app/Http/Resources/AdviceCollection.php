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
            $_item = $item;
            if (isset($item['like_advice_status'])) {
                if ($item['like_advice_status'] == 1) {
                    $like = 1;
                }
                else if ($item['like_advice_status'] ==  0){
                    $like = -1;
                }

            }
            else {
                $like = null;
            }
            $_item['like'] = $like;
            unset( $_item['like_advice_id']);
            unset( $_item['like_advice_status']);
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
