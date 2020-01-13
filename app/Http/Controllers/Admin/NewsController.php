<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $per_page = 10;
        $keyword = $request->get('keywword', null);
        if ($keyword) {
            $news = News::with(['category'])->orderBy("updated_at", 'DESC')->where('title', 'LIKE', "%$keyword%")->paginate($per_page);
        }
        else
            $news = News::with(['category'])->orderBy("updated_at", 'DESC')->paginate($per_page);
        return view('admin.news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = NewsCategory::pluck('name', 'id');
        return view('admin.news.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {

        $news = News::create($request->all());
//        $request->thumbnail->storeAs('thumbs', $request->thumbnail->getClientOriginalName());
//        $request->image->storeAs('images', $request->thumbnail->getClientOriginalName());

        $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('images/'), $imageName);

        $thumbName = time().'.'. $request->file('thumbnail')->getClientOriginalExtension();
        $request->file('thumbnail')->move(public_path('images/thumb/'), $thumbName);
        News::where('id', $news->id)->update(['image' => $imageName, 'thumbnail' => $thumbName]);
        return redirect(route('news.index'))->with('success', 'Created News successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $categories = NewsCategory::pluck('name', 'id');
        $news = News::findOrFail($id);
        return view('admin.news.show')->with('news', $news)->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $categories = NewsCategory::pluck('name', 'id');
        $news = News::findOrFail($id);
        return view('admin.news.edit')->with('news', $news)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = News::findOrFail($id);
        if ($news) {
            News::where('id', $id)->update($request->only([
                'title', 'category_id', 'short_desc', 'content', 'image', 'thumbnail', 'published_date', 'author', 'status'
            ]));
            if ($request->file('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images/'), $imageName);
                News::where('id', $id)->update(['image' => $imageName]);
            }
            if ($request->file('thumbnail')) {
                $thumbName = time() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $request->file('thumbnail')->move(public_path('images/thumb/'), $thumbName);
                News::where('id', $id)->update(['thumbnail' => $thumbName]);
            }

            return redirect(route('news.index'))->with('success', 'Update News successfully!');
        }
        else {
            return redirect(route('news.index'))->with('error', 'Not found News ID!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            News::where('id', $id)->delete();
            return redirect(route('news.index'))->with('success', 'Deleted News Successful!');
        }
        else {
            return redirect(route('news.index'))->with('error', 'Not found News!');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public  function active($id){
        $news = News::find($id);
        if ($news) {
            News::where('status', 1)->update(['status' => 2] );
            News::where('id', $id)->update(['status' => 1] );
            return redirect(route('news.index'))->with('success', 'Active News Successful!');
        }
        else {
            return redirect(route('news.index'))->with('error', 'Not found News!');
        }
    }
}
