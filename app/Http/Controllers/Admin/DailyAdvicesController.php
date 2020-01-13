<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdviceRequest;
use App\Models\DailyAdvice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;

class DailyAdvicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $perpage = $request->get('limit', 10);;
        $keyword = $request->get('keywword', null);
        if ($keyword) {
            $advices = DailyAdvice::orderBy("updated_at", 'DESC')->orderBy("status", 'DESC')->where('advice', 'LIKE', "%$keyword%")->paginate($perpage);
        }
        else
            $advices = DailyAdvice::orderBy("updated_at", 'DESC')->orderBy("status", 'DESC')->paginate($perpage);
        return view('admin.advices.index', ['advices' => $advices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.advices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdviceRequest $request
     * @return Response
     */
    public function store(AdviceRequest $request)
    {
        //$validated = $request->validated();
        if($request->get('status') == 1) {
            DailyAdvice::where('status', 1)->update(['status' => 2] );
        }
        DailyAdvice::create($request->all());

        return redirect(route('daily_advices.index'))->with('success', 'Created Advice successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            return view('admin.daily_advices.show')->with('advice', $advice);
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            return view('admin.advices.edit')->with('advice', $advice);
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdviceRequest $request
     * @param int $id
     * @return Response
     */
    public function update(AdviceRequest $request, $id)
    {
        $advice = DailyAdvice::findOrFail($id);
        if ($advice) {
            DailyAdvice::where('id', $id)->update($request->only(['author', 'advice', 'status']));
            if($request->get('status') == 1) {
                DailyAdvice::where('status', 1)->update(['status' => 2] );
            }
            return redirect(route('daily_advices.index'))->with('success', 'Update Daily Advice successfully!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            DailyAdvice::where('id', $id)->delete();
            return redirect(route('daily_advices.index'))->with('success', 'Deleted Advice Successful!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public  function active($id){
        $advice = DailyAdvice::find($id);
        if ($advice) {
            DailyAdvice::where('status', 1)->update(['status' => 2] );
            DailyAdvice::where('id', $id)->update(['status' => 1] );
            return redirect(route('daily_advices.index'))->with('success', 'Active Advice Successful!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }
}
