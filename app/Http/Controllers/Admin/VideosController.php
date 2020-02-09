<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = env('NUM_ITEM_PER_PAGE', 10);
        $keyword = $request->get('keywword', null);
        if ($keyword) {
            $videos = Video::with(['category'])->orderBy("updated_at", 'DESC')->where('title', 'LIKE', "%$keyword%")->paginate($per_page);
        }
        else
            $videos = Video::with(['category'])->orderBy("updated_at", 'DESC')->paginate($per_page);
        return view('admin.videos.index', ['videos' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = VideoCategory::pluck('name', 'id');
        return view('admin.videos.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        Video::create($request->all());
        return redirect(route('videos.index'))->with('success', 'Created Video successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = VideoCategory::pluck('name', 'id');
        $video = Video::findOrFail($id);
        return view('admin.videos.show')->with('video', $video)->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = VideoCategory::pluck('name', 'id');
        $video = Video::findOrFail($id);
        return view('admin.videos.edit')->with('video', $video)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        if ($video) {
            Video::where('id', $id)->update($request->only([
                'title', 'category_id', 'thumb', 'description', 'source', 'link', 'status'
            ]));

            return redirect(route('videos.index'))->with('success', 'Update Video successfully!');
        }
        else {
            return redirect(route('videos.index'))->with('error', 'Not found Video ID!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video) {
            Video::where('id', $id)->delete();
            return redirect(route('videos.index'))->with('success', 'Deleted Video Successful!');
        }
        else {
            return redirect(route('videos.index'))->with('error', 'Not found Video!');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public  function active($id){
        $video = Video::find($id);
        if ($video) {
            Video::where('id', $id)->update(['status' => 1] );
            return redirect(route('videos.index'))->with('success', 'Active Video Successful!');
        }
        else {
            return redirect(route('videos.index'))->with('error', 'Not found Videos!');
        }
    }
}
