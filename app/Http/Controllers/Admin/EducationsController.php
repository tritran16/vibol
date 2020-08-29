<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\BookCategoryRequest;
use App\Models\Education;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Video;
use App\Repositories\EducationRepository;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EducationsController extends Controller
{
    private $educationsRepository;

    public function __construct(EducationRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->educationsRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educations = $this->educationsRepository->all();
        return view('admin.educations.index')->with('educations', $educations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.educations.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EducationRequest $request)
    {
        if (!$request->hasFile('image')) {
            return redirect(route('educations.create'))
                ->withErrors([__('Image Education is required')])
                ->withInput();
        }

        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('educations/'.  $img_name, File::get($image));
           // Education::where('id', $education->id)->update([ 'image' => 'storage/education/'.$img_name]);
            $data = array_merge($request->only(['name', 'link', 'description']),[ 'image' => 'storage/educations/'.$img_name]);
            $education = Education::create($data);
        }

        return redirect(route('educations.index'))->with('success', 'Created Education successfully!');//

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
        $education = Education::findOrFail($id);
        return view('admin.educations.edit')->with('education', $education);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EducationRequest $request, $id)
    {
        $education = Education::findOrFail($id);

        Education::where('id', $id)->update($request->only(['name', 'link', 'description']));
        if ($request->file('image')){
            $image = $request->file('image');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('educations/'.  $img_name, File::get($image));
            Education::where('id', $education->id)->update([ 'image' => 'storage/educations/'.$img_name]);
        }
        return redirect(route('educations.index'))->with('success', 'Update Education successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Education::where('id', $id)->delete();
        return redirect(route('educations.index'))->with('success', 'Deleted Education Successful!');

    }
}
