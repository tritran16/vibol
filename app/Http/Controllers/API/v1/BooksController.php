<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\LikeBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\BookCategory as BookCategoryResource;

if (!defined('API_PAGE_LIMITED'))
    define('API_PAGE_LIMITED', 10);
class BooksController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $keyword = $request->get('keyword');
        $device_id = $request->get('device_id');
        $books = Book::select('books.id', 'name', 'books.thumbnail', 'books.category_id' , 'books.filename', 'books.link',
            'books.page_number', 'books.author','books.description', 'books.status', 'books.likes', 'books.views', 'books.is_hot',
            'books.created_at', 'books.updated_at', 'like_books.id  AS  like_book_id')
            ->with('category')
            ->leftJoin('like_books', 'like_books.book_id', '=', 'books.id')
            ->where('status', 1)
            ->where('like_books.device_id', $device_id);
        if ($keyword) {
            $books = $books
                ->where('books.name', 'LIKE', "%$keyword%");
        }
        if ( $request->get('is_hot')){
            $books = $books->where('is_hot', 1);
        }
        if ( $category_id = $request->get('category_id')){
            $books = $books->where('category_id', $category_id);
        }

        $direction = $request->get('direction') == 'desc' ? 'desc' : 'asc';
        switch ($request->get('order') ) {
            case 'view' :
                $books->orderBy('views', $direction);
            case 'like':
                $books->orderBy('likes', $direction);
            default:
                // TODO
        }
        $books->groupBy('books.id', 'name', 'books.thumbnail', 'books.category_id' , 'books.filename', 'books.link',
            'books.page_number', 'books.author','books.description', 'books.status', 'books.likes', 'books.views', 'books.is_hot',
            'books.created_at', 'books.updated_at', 'like_books.id');
        // short by id desc
        $books->orderBy('created_at', 'DESC');

        $data = $books->paginate(API_PAGE_LIMITED);
        return $this->successResponse(new BookCollection($data));
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
            $book->views += 1;
            $device_id = $request->get('device_id');
            $is_like = LikeBook::where('book_id', $id)
                ->where('device_id', $device_id)
                ->first();
            $book->is_like = isset($is_like) ? 1 : 0;
            return $this->successResponse(new BookResource($book));
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
            $book->is_like = 1;
           // Book::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
            $device_id = $request->get('device_id');
            $is_like = LikeBook::where('book_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if (!$is_like) {
                LikeBook::create(['device_id' => $device_id, 'book_id' => $id]);

                Book::where('id', $id)->update(['likes' => DB::raw('likes + 1'),]);
                $book->likes += 1;
                return $this->successResponse(new BookResource($book), __('likeBookSuccess'));
            }
            else return $this->successResponse(new BookResource($book), __('likeBookSuccess'));
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
            $book->is_like = 0;
            $device_id = $request->get('device_id');
            $is_like = LikeBook::where('book_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($is_like) {
                LikeBook::where('device_id' , $device_id)->where('book_id', $id)->delete();

                Book::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
                $book->likes = $book->likes> 0? $book->likes-1: 0;

                return $this->successResponse(new BookResource($book), __('unlikeBookSuccess'));
            }
            else return $this->successResponse(new BookResource($book), __('unlikeBookSuccess'));
        }
        else return $this->failedResponse([], __('notFoundBook'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request) {
        $categories = BookCategory::get();
        return $this->successResponse($categories);
    }
}
