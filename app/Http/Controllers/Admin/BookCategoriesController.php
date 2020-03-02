<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCategoryRequest;
use App\Models\Book;
use App\Models\BookCategory;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;

class BookCategoriesController extends Controller
{
    private $bookCategoryRepository;

    public function __construct(BookCategoryRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->bookCategoryRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->bookCategoryRepository->all();
        return view('admin.books.categories.index')->with('book_categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCategoryRequest $request)
    {
        BookCategory::create($request->only(['name', 'description']));

        return redirect(route('book_categories.index'))->with('success', 'Created Book Category successfully!');//

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
        $category = BookCategory::findOrFail($id);
        return view('admin.books.categories.edit')->with('book_category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = BookCategory::findOrFail($id);
        BookCategory::where('id', $id)->update($request->only(['name', 'description']));
        return redirect(route('book_categories.index'))->with('success', 'Update Book Category successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = BookCategory::find($id);
        if ($category) {
            $books = Book::where('category_id', $id)->get();
            if ($books) {
                return redirect(route('book_categories.index'))->with('error', 'Please delete all book of this category!');
            }
            BookCategory::where('id', $id)->delete();
            return redirect(route('book_categories.index'))->with('success', 'Deleted Book Category Successful!');
        }
        else {
            return redirect(route('book_categories.index'))->with('error', 'Not found Book Category!');
        }
    }
}
