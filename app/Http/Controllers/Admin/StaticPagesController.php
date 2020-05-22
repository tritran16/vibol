<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCategoryRequest;
use App\Models\StaticPage;
use App\Models\Book;
use App\Models\BookCategory;
use App\Repositories\StaticPageRepository;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    private $static_pagesRepository;

    public function __construct(StaticPageRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->static_pagesRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $static_pages = $this->static_pagesRepository->all();
        return view('admin.static_pages.index')->with('static_pages', $static_pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ['ABOUT_US'  => __('ABOUT_US')];
        return view('admin.static_pages.create')->with('types', $types);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCategoryRequest $request)
    {
        StaticPage::create($request->only(['key', 'image', 'title', 'content']));

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
        $static_page = StaticPage::findOrFail($id);
        return view('admin.static_pages.edit')->with('static_page', $static_page);
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
        $static_page = StaticPage::findOrFail($id);
        StaticPage::where('id', $id)->update($request->only(['key', 'image', 'title', 'content']));
        return redirect(route('static_pages.index'))->with('success', 'Update StaticPage successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StaticPage::where('id', $id)->delete();
        return redirect(route('static_pages.index'))->with('success', 'Deleted StaticPage Successful!');

    }

    function aboutUs(){
        $page = StaticPage::where('key', 'ABOUT_US')->first();
        $content = $page?$page->content:'';

        return view('admin.static_pages.about_us')->with('content', $content);
    }
    function editAboutUs(){
        $page = StaticPage::where('key', 'ABOUT_US')->first();
        $content = $page?$page->content:'';

        return view('admin.static_pages.edit_about_us')->with('content', $content);
    }

    function saveAboutUs(Request $request){
        $page = StaticPage::where('key', 'ABOUT_US')->first();
        $content = $request->get('content');
        if ($page){
            $page->update(['content' => $content]);
        }
        else {
            StaticPage::create(['key' => 'ABOUT_US', 'content' => $content]);
        }


        return redirect(route('page.about_us'))->with('success', 'Updated About Us Page Successful!');
    }
}
