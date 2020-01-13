<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;
use Input;
use Session;
use Redirect;

const NUM_OF_PAGINATION = 15;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $province = Province::paginate(NUM_OF_PAGINATION);

        return View::make('admin.provinces.index')
            ->with('provinces', $province);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ProvinceRequest $request)
    {
        $validated = $request->validated();

        $province = new Province;
        $province->name = Input::get('name');
        $province->code = Input::get('code');
        $province->description = Input::get('description');
        $province->save();

        // redirect
        Session::flash('message', 'Created province successfully!');

        return redirect(route('province.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $province = Province::find($id);

        // show the view and pass the province to it
        return View::make('admin.provinces.show')
            ->with('province', $province);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $province = Province::find($id);

        // show the view and pass the province to it
        return View::make('admin.provinces.edit')
            ->with('province', $province);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProvinceRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ProvinceRequest $request, $id)
    {
        $validated = $request->validated();

        $province = Province::findorfail($id);
        $province->name = Input::get('name');
        $province->description = Input::get('description');
        $province->save();

        // redirect
        Session::flash('success', 'Update province successfully!');

        return redirect(route('province.index'));
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
        $province = Province::find($id);
        $province->delete();

        // redirect
        Session::flash('success', 'Delete Province successful!');
        return redirect(route('province.index'));
    }
}
