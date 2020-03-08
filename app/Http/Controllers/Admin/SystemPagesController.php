<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\SystemPage;
use App\Repositories\SystemPageRepository;
use Illuminate\Http\Request;

class SystemPagesController extends Controller
{
    private $systemPageRepository;

    public function __construct(SystemPageRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->systemPageRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->systemPageRepository->all();
        return view('admin.system_pages.index')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.system_pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        SystemPage::create($request->only(['name', 'url',  'status']));

        return redirect(route('system_pages.index'))->with('success', 'Created System Share Page successfully!');//
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
        $page = SystemPage::findOrFail($id);
        return view('admin.system_pages.edit')->with('page', $page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        $page = SystemPage::findOrFail($id);
        SystemPage::where('id', $id)->update($request->only(['name', 'url',  'status']));
        return redirect(route('system_pages.index'))->with('success', 'Update System Share Page successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SystemPage::where('id', $id)->delete();
        return redirect(route('system_pages.index'))->with('success', 'Deleted System Share Page Successful!');
    }
}
