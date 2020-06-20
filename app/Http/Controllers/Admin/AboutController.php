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
use Illuminate\Http\Response;
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

        $abouts = About::all();
        return view('admin.abouts.index', ['abouts' => $abouts]);
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
        $data = $request->all();
        if ($request->file('image')){
            $image = $request->file('image');
            $image_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('abouts/images/'.  $image_name, File::get($image));
            $data = array_merge($request->only(['content', 'video_link']), ['image' => 'storage/abouts/images/'. $image_name]);
            $about = About::create($data);
        }
        else {
            $about = About::create($request->all());
        }




        return redirect(route('abouts.index'))->with('success', 'Created About Me Page successfully!');//
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
        $about = About::findOrFail($id);

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
            $data = array_merge($request->only(['content', 'video_link']), ['image' => 'storage/about/image/'. $image_name]);
            $about = About::where('id', $id)->update($data);
        }
        else {
            About::where('id', $id)->update($request->only(['content', 'video_link']));
        }

        return redirect(route('abouts.index'))->with('success', 'Update About Information successfully!');//
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $about = About::find($id);
        $about->delete();


        return redirect(route('abouts.index'))->with('success', 'Deleted About Me item successfully!');
    }


}
