<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoCategoryRequest;
use App\Models\VideoCategory;
use App\Repositories\VideoCategoryRepository;
use Illuminate\Http\Request;

class VideoCategoriesController extends Controller
{
    private $videoCategoryRepository;

    public function __construct(VideoCategoryRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->videoCategoryRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->videoCategoryRepository->all();
        return view('admin.videos.categories.index')->with('video_categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.videos.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoCategoryRequest $request)
    {
        VideoCategory::create($request->only(['name', 'description']));

        return redirect(route('video_categories.index'))->with('success', 'Created Video Category successfully!');//

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
        $category = VideoCategory::findOrFail($id);
        return view('admin.videos.categories.edit')->with('video_category', $category);
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
        $category = VideoCategory::findOrFail($id);
        VideoCategory::where('id', $id)->update($request->only(['name', 'description']));
        return redirect(route('video_categories.index'))->with('success', 'Update Video Category successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = VideoCategory::find($id);
        if ($category) {
            VideoCategory::where('id', $id)->delete();
            return redirect(route('videos_categories.index'))->with('success', 'Deleted Video Category Successful!');
        }
        else {
            return redirect(route('videos_categories.index'))->with('error', 'Not found Video Category!');
        }
    }
}
