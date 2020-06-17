<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AboutRequest;
use App\Http\Requests\PageRequest;
use App\Models\About;
use App\Models\Poetry;
use App\Models\SystemPage;
use DemeterChain\A;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = About::first();

        return view('admin.abouts.index', ['about' => $about]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.abouts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutRequest $request)
    {
        if ($request->file('image')){
            $image = $request->file('image');
            $image_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('about/image/'.  $image_name, File::get($image));
            $data = array_merge($request->only(['content', 'video_link']), ['image' => 'storage/poetry/images/'. $image_name]);
            $about = About::create($data);
            //About::where('id', $about->id)->update([ ]);
        }

        return redirect(route('system_pages.index'))->with('success', 'Created System Share Page successfully!');//
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $about = About::first();
        return view('admin.abouts.index', ['about' => $about]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = About::first();

        return view('admin.abouts.edit', ['about' => $about]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AboutRequest $request, $id)
    {
        if ($request->file('image')){
            $image = $request->file('image');
            $image_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('about/image/'.  $image_name, File::get($image));
            $data = array_merge($request->only(['content', 'video_link']), ['image' => 'storage/poetry/images/'. $image_name]);
            $about = About::where('id', $id)->update($data);
            //About::where('id', $about->id)->update([ ]);
        }
        else {
            About::where('id', $id)->update($request->only(['content', 'video_link']));
        }

        return redirect(route('abouts.index'))->with('success', 'Update About Information successfully!');//
    }


}
