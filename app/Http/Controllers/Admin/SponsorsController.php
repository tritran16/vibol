<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRequest;
use App\Http\Requests\BookCategoryRequest;
use App\Models\Sponsor;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Video;
use App\Repositories\SponsorRepository;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SponsorsController extends Controller
{
    private $sponsorsRepository;

    public function __construct(SponsorRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->sponsorsRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = $this->sponsorsRepository->all();
        return view('admin.sponsors.index')->with('sponsors', $sponsors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sponsors.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request)
    {
        $sponsor = Sponsor::create($request->only(['name', 'description']));

        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('sponsors/'.  $img_name, File::get($image));

            Sponsor::where('id', $sponsor->id)->update([ 'image' => 'storage/sponsors/'.$img_name]);

        }

        return redirect(route('sponsors.index'))->with('success', 'Created Sponsor successfully!');//

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
        $sponsor = Sponsor::findOrFail($id);
        return view('admin.sponsors.edit')->with('sponsor', $sponsor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorRequest $request, $id)
    {
        $sponsor = Sponsor::findOrFail($id);

        Sponsor::where('id', $id)->update($request->only([ 'name', 'description']));
        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('sponsors/'.  $img_name, File::get($image));
            Sponsor::where('id', $sponsor->id)->update([ 'image' => 'storage/sponsors/'.$img_name]);
        }
        return redirect(route('sponsors.index'))->with('success', 'Update Sponsor successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sponsor::where('id', $id)->delete();
        return redirect(route('sponsors.index'))->with('success', 'Deleted Sponsor Successful!');

    }
}
