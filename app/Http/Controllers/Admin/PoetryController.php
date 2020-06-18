<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PoetryRequest;
use App\Models\News;
use App\Models\Poetry;
use App\Models\PoetryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PoetryController extends Controller
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
            $poetrys = Poetry::orderBy("updated_at", 'DESC')->where('title', 'LIKE', "%$keyword%")->paginate($per_page);
        }
        else
            $poetrys = Poetry::orderBy("updated_at", 'DESC')->paginate($per_page);
        return view('admin.poetrys.index', ['poetrys' => $poetrys]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.poetrys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PoetryRequest $request)
    {
        if (!$request->hasFile('thumbnail')) {
            return redirect('/admin/poetrys/create')
                ->withErrors(['Thumbnail File is required'])
                ->withInput();
        }
        $poetry = Poetry::create( $request->only([
            'title', 'thumb', 'content', 'source', 'video_link', 'status', 'is_hot'
        ]));

        if ($request->file('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
            Storage::disk('public')->put('poetry/images/'. $poetry->id . '/'. $thumbnail_name, File::get($thumbnail));
            Poetry::where('id', $poetry->id)->update([ 'thumbnail' => 'storage/poetry/images/'. $poetry->id . '/'.$thumbnail_name]);
        }
        return redirect(route('poetrys.index'))->with('success', 'Created Poetry successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poetry = Poetry::findOrFail($id);
        return view('admin.poetrys.show')->with('poetry', $poetry);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poetry = Poetry::findOrFail($id);
        return view('admin.poetrys.edit')->with('poetry', $poetry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PoetryRequest $request, $id)
    {
        $poetry = Poetry::findOrFail($id);
        if ($poetry) {
            $data = $request->only([
                'title', 'thumb', 'content', 'source', 'video_link', 'status', 'is_hot'
            ]);
            $data['is_hot'] = isset($data['is_hot']) ? $data['is_hot'] : 0;
            Poetry::where('id', $id)->update($data);
            if ($request->file('thumbnail')){
                $thumbnail = $request->file('thumbnail');
                $thumbnail_name  = urlencode($thumbnail->getClientOriginalName()) ;
                Storage::disk('public')->put('poetry/images/'. $poetry->id . '/'. $thumbnail_name, File::get($thumbnail));
                Poetry::where('id', $poetry->id)->update([ 'thumbnail' => 'storage/poetry/images/'. $poetry->id . '/'.$thumbnail_name]);
            }
            return redirect(route('poetrys.index'))->with('success', 'Update Poetry successfully!');
        }
        else {
            return redirect(route('poetrys.index'))->with('error', 'Not found Poetry ID!');
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
        $poetry = Poetry::find($id);
        if ($poetry) {
            Poetry::where('id', $id)->delete();
            return redirect(route('poetrys.index'))->with('success', 'Deleted Poetry Successful!');
        }
        else {
            return redirect(route('poetrys.index'))->with('error', 'Not found Poetry!');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public  function active($id){
        $poetry = Poetry::find($id);
        if ($poetry) {
            Poetry::where('id', $id)->update(['status' => 1] );
            return redirect(route('poetrys.index'))->with('success', 'Active Poetry Successful!');
        }
        else {
            return redirect(route('poetrys.index'))->with('error', 'Not found Poetry!');
        }
    }
}
