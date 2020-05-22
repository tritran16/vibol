<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\BookCategoryRequest;
use App\Models\Banner;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Video;
use App\Repositories\BannerRepository;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    private $bannersRepository;

    public function __construct(BannerRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->bannersRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = $this->bannersRepository->all();
        return view('admin.banners.index')->with('banners', $banners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ['ADVICE'  => 'ADVICE', 'VIDEO' => 'VIDEO', 'NEWS' => 'NEWS', 'BOOK'  => 'BOOK'];
        return view('admin.banners.create')->with('types', $types);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        if (!$request->hasFile('image')) {
            return redirect(route('banners.create'))
                ->withErrors([__('Image Banner is required')])
                ->withInput();
        }

        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('banners/'.  $img_name, File::get($image));
           // Banner::where('id', $banner->id)->update([ 'image' => 'storage/banner/'.$img_name]);
            $data = array_merge($request->only(['type', 'title', 'content']),[ 'image' => 'storage/banners/'.$img_name]);
            $banner = Banner::create($data);
        }

        return redirect(route('banners.index'))->with('success', 'Created Banner successfully!');//

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
        $banner = Banner::findOrFail($id);
        $types = ['ADVICE'  => 'ADVICE', 'VIDEO' => 'VIDEO', 'NEWS' => 'NEWS', 'BOOK'  => 'BOOK'];
        return view('admin.banners.edit')->with('banner', $banner)->with('types', $types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        Banner::where('id', $id)->update($request->only(['type', 'title', 'content']));
        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('banners/'.  $img_name, File::get($image));
            Banner::where('id', $banner->id)->update([ 'image' => 'storage/banners/'.$img_name]);
        }
        return redirect(route('banners.index'))->with('success', 'Update Banner successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::where('id', $id)->delete();
        return redirect(route('banners.index'))->with('success', 'Deleted Banner Successful!');

    }
}
