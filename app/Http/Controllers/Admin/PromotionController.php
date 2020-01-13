<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Province;
use App\Models\Promotion;
use App\Models\Store;
use App\Repositories\PromotionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;
use Input;
use Session;
use Redirect;

const NUM_OF_PAGINATION = 15;

class PromotionController extends Controller
{
    private $promotionRepository;
    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->middleware('auth:admin');
        $this->promotionRepository = $promotionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $promotions = Promotion::with(['store'])->orderBy('updated_at', 'DESC')->paginate(NUM_OF_PAGINATION);
        $stores = Store::pluck('name', 'id');
        $statuses = [0 => 'New', 1 => 'Public', 2 =>  'Un-Public'];
        return View::make('admin.promotions.index', ['statuses'=> $statuses, 'stores' => $stores])
            ->with('promotions', $promotions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $provinces = Province::pluck('name', 'id')->toArray();

        $stores = Store::pluck('name', 'id')->toArray();
        $provinces[''] = 'Select Province';
        $statuses = [0 => 'Un-Active', 1 => 'Active', 2 =>  'Banned'];
        return View::make('admin.promotions.create', ['provinces' => $provinces, 'statuses' => $statuses, 'stores' =>$stores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(PromotionRequest $request)
    {
        $validated = $request->validated();

        $this->promotionRepository->bulkInsert($request->all());

        // redirect
        Session::flash('message', 'Created Promotion successfully!');

        return redirect(route('protion.index'));
    }

    /**
     * Promotion a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function promotion(PromotionRequest $request)
    {
        $validated = $request->validated();

        $this->promotionRepository->bulkInsert($request->all());

        // redirect
        Session::flash('message', 'Created promotion successfully!');

        return redirect(route('promotion.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $promotion = Promotion::with(['store'])->find($id);
        if ($promotion) {
            $store = Store::where('id', $promotion->store_id);
            // show the view and pass the promotion to it
            return View::make('admin.promotions.show')
            ->with('promotion', $promotion)->with('store', $store);
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
        $promotion = Promotion::with('store')->find($id);
        $statuses = [0 => 'Un-Active', 1 => 'Active', 2 =>  'Banned'];
        $provinces = Province::pluck('name', 'id');
        $provinces[''] = 'Select Province';
        // show the view and pass the promotion to it
        return View::make('admin.promotions.edit', ['provinces' => $provinces, 'statuses' => $statuses])
            ->with('promotion', $promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PromotionRequest $request
     * @param int $id
     * @return Response
     */
    public function update(PromotionRequest $request, $id)
    {
        $validated = $request->validated();

        $this->promotionRepository->updatePromotion($request->all());

        // redirect
        Session::flash('success', 'Update promotion successfully!');

        return redirect(route('promotion.index'));
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
        $promotion = Promotion::find($id);
        $promotion->delete();

        // redirect
        Session::flash('success', 'Delete Promotion successful!');
        return redirect(route('promotion.index'));
    }
}
