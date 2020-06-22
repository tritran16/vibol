<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

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
        $categories = [];
        $_categories = NewsCategory::all();
        $categories[""] = 'Select Category';
        foreach ($_categories as $category) {
            $categories[$category->id] = $category->translate('kh')->name;

        }
        return view('admin.news.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
//        $news = News::create($request->only('title', 'short_desc', 'category_id', 'author',
//            'content', 'source', 'status', 'published_date'));
//        $request->thumbnail->storeAs('thumbs', $request->thumbnail->getClientOriginalName());
//        $request->image->storeAs('images', $request->thumbnail->getClientOriginalName());

//        $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
//        $request->file('image')->move(public_path('images/'), $imageName);
//
//        $thumbName = time().'.'. $request->file('thumbnail')->getClientOriginalExtension();
//        $request->file('thumbnail')->move(public_path('images/thumb/'), $thumbName);
        $validate = Validator::make(
            $request->all(), [
//            'title_en' => 'required|string|max:255',
//            'short_desc_en' => 'required',
//            'content_en' => 'required|string',
//            'title_kh' => 'required|string|max:255',
//            'short_desc_kh' => 'required|string',
//            'content_kh' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8000',
            'video_link' => 'nullable|active_url'
        ]);
        $categories = [];
        $_categories = NewsCategory::all();
        $categories[""] = 'Select Category';
        foreach ($_categories as $category) {
            $categories[$category->id] = $category->translate('kh')->name;

        }
        if ($validate->fails()) {

            return View('admin.news.create')->withErrors($validate)
                ->with('categories', $categories);
        }
        else {
            if (!$request->get('title_en') || !$request->get('title_kh')
                || !$request->get('short_desc_en') || !$request->get('short_desc_kh')
                || !$request->get('content_en') || !$request->get('content_kh')
            ) {
                if (!$request->get('title_kh'))
                    $validate->getMessageBag()->add('title_kh', 'Title Khmer Not empty');
                if (!$request->get('short_desc_kh'))
                    $validate->getMessageBag()->add('short_desc_kh', 'Short Desc Khmer Not empty');
                if (!$request->get('content_kh'))
                    $validate->getMessageBag()->add('short_desc_kh', 'Content Khmer of news Not empty');
                if (!$request->get('title_en'))
                    $validate->getMessageBag()->add('title_en', 'Title English Not empty');

                if (!$request->get('short_desc_en'))
                    $validate->getMessageBag()->add('short_desc_en', 'Short Desc English Not empty');
                if (!$request->get('content_en'))
                    $validate->getMessageBag()->add('short_desc_kh', 'Content English of news Not empty');
                return View('admin.news.create')->withErrors($validate)
                    ->with('categories', $categories);
            }
        }

        $data = [
            'en' => [
                'title'       => $request->input('title_en'),
                'short_desc' => $request->input('short_desc_en'),
                'content' => $request->input('content_en'),
            ],
            'kh' => [
                'title'       => $request->input('title_kh'),
                'short_desc' => $request->input('short_desc_kh'),
                'content' => $request->input('content_kh'),
            ],
        ];
        $news = News::create(array_merge($request->only('title', 'short_desc', 'category_id', 'author',
            'content', 'source', 'status', 'published_date', 'is_hot'), $data));

        if ($request->file('image')){
            $image = $request->file('image');
            $file_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('news/images/'. $news->id . '/' . $file_name, File::get($image));
            News::where('id', $news->id)->update(['image' => 'storage/news/images/'. $news->id . '/' . $file_name]);

        }

        if ($request->file('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
            Storage::disk('public')->put('news/thumbnails/'. $news->id . '/'. $thumbnail_name, File::get($thumbnail));
            News::where('id', $news->id)->update([ 'thumbnail' => 'storage/news/thumbnails/'. $news->id . '/'. $thumbnail_name]);
        }


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
        $_categories = NewsCategory::all();
        $categories = [];
        $categories[""] = 'Select Category';
        foreach ($_categories as $category) {
            $categories[$category->id] = $category->translate('kh')->name;

        }

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
        $_categories = NewsCategory::all();
        $categories = [];
        $categories[""] = 'Select Category';
        foreach ($_categories as $category) {
            $categories[$category->id] = $category->translate('kh')->name;

        }

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
            $post_data = $request->only([
                'category_id', 'video_link', 'published_date', 'author', 'status', 'is_hot'
            ]);
            $post_data['is_hot'] = isset($post_data['is_hot'])?$post_data['is_hot']:0;
            News::where('id', $id)->update($post_data);

            $data = [
                'en' => [
                    'title'       => $request->input('title_en'),
                    'short_desc' => $request->input('short_desc_en'),
                    'content' => $request->input('content_en'),
                ],
                'kh' => [
                    'title'       => $request->input('title_kh'),
                    'short_desc' => $request->input('short_desc_kh'),
                    'content' => $request->input('content_kh'),
                ],
            ];
            $news = $news->update($data);

//            if ($request->file('image')) {
//                $image = $request->file('image');
//                $file_name  = urlencode($image->getClientOriginalName()) ;
//                Storage::disk('public')->put('news/images/'. $id . '/'. $file_name, File::get($image));
//                News::where('id', $id)->update(['image' => 'storage/news/images/'. $id . '/'.$file_name]);
//            }

            if ($request->file('thumbnail')){
                $thumbnail = $request->file('thumbnail');
                $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
                Storage::disk('public')->put('news/thumbnails/'. $id . '/'. $thumbnail_name, File::get($thumbnail));
                News::where('id', $id)->update([ 'thumbnail' => 'storage/news/thumbnails/'. $id . '/'.$thumbnail_name]);
            }

            return redirect(route('news.index'))->with('success', 'Update News successfully!');
        }
        else {
            return redirect(route('news.index'))->with('error', 'Not found News!');
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
           // News::where('status', 1)->update(['status' => 2] );
            News::where('id', $id)->update(['status' => 1] );
            return redirect(route('news.index'))->with('success', 'Active News Successful!');
        }
        else {
            return redirect(route('news.index'))->with('error', 'Not found News!');
        }
    }
}
