<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

if (!defined('API_PAGE_LIMITED'))
    define('API_PAGE_LIMITED', 10);
class BooksController extends ApiController
{
    //
    public function index(Request $request){
        $keyword = $request->get('keyword');
        if (!$keyword) {
            $data = Book::with('category')
                ->where('status', 1)
                ->paginate(API_PAGE_LIMITED);
        }
        else {
            $data = Book::with('category')
                ->where('status', 1)
                ->where('books.name', 'LIKE', "%$keyword%")
                ->paginate(API_PAGE_LIMITED);
        }
        return $this->successResponse($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function  view(Request $request, $id){
        $book = Book::with('category')->find($id);
        if ($book && $book->status == 1) {
            Book::where('id', $id)->update(['views'=> DB::raw('views + 1'), ]);
            return $this->successResponse($book);
        }
        else {
            return $this->failedResponse(null, 'Not Found');
        }
    }

    /**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function like(Request $request, $id){
        $book = Book::find($id);
        if ($book && $book->status == 1) {
            Book::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
            $book->likes +=1;
            return $this->successResponse($book, __('likeBookSuccess'));
        }
        else return $this->failedResponse([], __('notFoundBook'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request, $id){
        $book = Book::find($id);
        if ($book && $book->status == 1) {
            Book::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
            $book->likes -=1;
            return $this->successResponse($book, __('unLikeBookSuccess'));
        }
        else return $this->failedResponse([], __('notFoundBook'));
    }
}
