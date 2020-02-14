<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookCategory;
use App\Repositories\BookRepository;
use App\Repositories\VideoCategoryRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    private $bookRepository;

    public function __construct(BookRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->bookRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword)
            $books = $this->bookRepository->findWhere(['name', 'LIKE', $request->get('keyword') ])->paginate(20);
        else $books = $this->bookRepository->paginate(20);
        return view('admin.books.index')->with('books', $books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BookCategory::pluck('name', 'id');
        return view('admin.books.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $file_name = '';
        if ($request->file('pdf_file')){
            $pdf_file = $request->file('pdf_file');
            $file_name  = $pdf_file->getClientOriginalName() ;
            Storage::disk('public')->put('books/pdf/'. $file_name, File::get($pdf_file));
            Book::create(array_merge($request->only(['name', 'category_id', 'description', 'status']),
                ['filename' => $file_name, 'link' => env('APP_URL') .'/storage/books/pdf/' . $file_name] ));
        }
        else {
            Book::create($request->only(['name', 'category_id', 'link', 'description', 'status']));
        }



        return redirect(route('books.index'))->with('success', 'Created Book successfully!');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = BookCategory::pluck('name', 'id');
        $book = Book::findOrFail($id);
        return view('admin.books.edit')->with('book', $book)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        if ($request->file('pdf_file')){
            $pdf_file = $request->file('pdf_file');
            $file_name  = $pdf_file->getClientOriginalName() ;
            Storage::disk('public')->put('books/pdf/'. $book->id . '/'. $file_name, File::get($pdf_file));
            $book = array_merge($request->only(['name', 'link', 'description', 'status']),
                ['filename' => $file_name, 'link' => env('APP_URL') .'storage/books/pdf/' . $book->id . '/'.  $file_name]
            );
        }
        else {
            $book = $request->only(['name', 'link', 'description', 'status']);
        }
        Book::where('id', $id)->update($book);

        return redirect(route('books.index'))->with('success', 'Update Book successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if ($book) {
            Book::where('id', $id)->delete();
            return redirect(route('books.index'))->with('success', 'Deleted Book Successful!');
        }
        else {
            return redirect(route('books.index'))->with('error', 'Not found Book!');
        }
    }
}
