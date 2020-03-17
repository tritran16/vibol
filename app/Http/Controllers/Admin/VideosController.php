<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\News;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        if (!$request->hasFile('thumbnail')) {
            dd(11111);
        }
        $video = Video::create($request->all());

        if ($request->file('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
            Storage::disk('public')->put('videos/thumbnails/'. $video->id . '/'. $thumbnail_name, File::get($thumbnail));
            Video::where('id', $video->id)->update([ 'thumbnail' => 'storage/videos/thumbnails/'. $video->id . '/'.$thumbnail_name]);
        }
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
            $data = $request->only([
                'title', 'category_id', 'thumb', 'description', 'source', 'link', 'status', 'is_hot'
            ]);
            $data['is_hot'] = isset($data['is_hot']) ? $data['is_hot'] : 0;
            Video::where('id', $id)->update($data);
            if ($request->file('thumbnail')){
                $thumbnail = $request->file('thumbnail');
                $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
                Storage::disk('public')->put('videos/thumbnails/'. $video->id . '/'. $thumbnail_name, File::get($thumbnail));
                Video::where('id', $video->id)->update([ 'thumbnail' => 'storage/videos/thumbnails/'. $video->id . '/'.$thumbnail_name]);
            }
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
