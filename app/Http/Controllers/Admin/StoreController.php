<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionDateRequest;
use App\Http\Requests\PromotionRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Promotion;
use App\Models\PromotionDate;
use App\Models\Province;
use App\Models\Shop;
use App\Models\Store;
use App\Repositories\PromotionRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psy\Util\Json;
use View;
use Input;
use Session;
use Redirect;

const NUM_OF_PAGINATION = 15;

class StoreController extends Controller
{
    private $storeRepository;
    private $promotionRepository;
    public function __construct(StoreRepository $storeRepository, PromotionRepository $promotionRepository)
    {
        $this->middleware('auth:admin');
        $this->storeRepository = $storeRepository;
        $this->promotionRepository = $promotionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stores = Store::with(['shops'])->paginate(NUM_OF_PAGINATION);

        $statuses = [0 => 'Un-Active', 1 => 'Active', 2 =>  'Banned'];
        return View::make('admin.stores.index', ['statuses'=> $statuses])
            ->with('stores', $stores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $provinces = Province::pluck('name', 'id');
        $provinces[''] = 'Select Province';
        $statuses = [0 => 'Un-Active', 1 => 'Active', 2 =>  'Banned'];
        return View::make('admin.stores.create', ['provinces' => $provinces, 'statuses' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $this->storeRepository->bulkInsert($request->all());

        // redirect
        Session::flash('message', 'Created store successfully!');

        return redirect(route('store.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $store = Store::find($id);
        $store->num_promotion_live = 0;
        $store->num_promotion_prepare = 0;
        $store->num_promotion_finished = 0;
        $store->num_promotion_cancel = 0;

        Promotion::where('store_id', $id)->count();
        // show the view and pass the store to it
        return View::make('admin.stores.show')
            ->with('store', $store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $store = Store::find($id);
        $statuses = [0 => 'Un-Active', 1 => 'Active', 2 =>  'Banned'];
        $provinces = Province::pluck('name', 'id');
        $provinces[''] = 'Select Province';
        // show the view and pass the store to it
        return View::make('admin.stores.edit', ['provinces' => $provinces, 'statuses' => $statuses])
            ->with('store', $store);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreRequest $request, $id)
    {
        $validated = $request->validated();

        $this->storeRepository->updateStore($request->all());

        // redirect
        Session::flash('success', 'Update store successfully!');

        return redirect(route('store.index'));
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
        $store = Store::find($id);
        $store->delete();

        // redirect
        Session::flash('success', 'Delete Store successful!');
        return redirect(route('store.index'));
    }


    public function addShop(Request $request, $id){
        $store = Store::with(['shops'])->find($id);

        // show the view and pass the store to it
        return View::make('admin.stores.add_shop')
            ->with('store', $store);
    }

    public function ajaxPostAddShop(Request $request, $id){
        $shop = $request->all();
        $shop['store_id'] = $id;
        $shop = Shop::create($shop);
        if ($shop)
         return Json::encode(['success' => true, 'message' => 'Add shop success', 'data' => $shop]);
        else
            return Json::encode(['success' => false, 'message' => 'Add shop failed']);
    }

    public function updateShop(Request $request, $shop_id){
        $shop = Shop::where('id', $shop_id)->first();
        return Json::encode(['success' => true, 'message' => 'Edit shop success', 'data' => $shop]);
    }
    public function postUpdateShop(Request $request, $store_id){
        $data = $request->all();
        if ($shop_id = $request->get('shop_id')){
            unset($data['shop_id']);
            $data['longitude'] = $data['lng'];
            unset($data['lng']);
            $data['latitude'] = $data['lat'];
            unset($data['lat']);
            unset($data['_token']);
            Shop::where('id', $shop_id)->update($data);
            $shop = Shop::where('id', $shop_id)->first();
            return Json::encode(['success' => true, 'message' => 'Edit shop success', 'data' => $shop]);
        }
        else {
            $data['store_id'] = $store_id;
            $shop = Shop::create($data);
            return Json::encode(['success' => true, 'message' => 'Edit shop success', 'data' => $shop]);
        }


    }

    public function deleteShop($id, $shop_id){
        $shop = Shop::where('id', $shop_id)->first();
        if ($shop) {
            Shop::where('id', $shop_id)->delete();
            return Json::encode(['success' => true, 'message' => 'Delete success'] );
        }
        else
            return Json::encode(['success' => false, 'message' => 'Delete shop failed']);

    }
    public function promotions(Request $request, $store_id){
        $statuses = [0 => 'New', 1 => 'Public', 2 => 'Un-public'];
        $store = Store::with(['promotions'])->find($store_id);
        // show the view and pass the store to it
        return View::make('admin.stores.promotions')
            ->with('store', $store)->with('statuses', $statuses);
    }

    public function deletePromotion($store_id, $promotion_id) {

        $promotion = Promotion::where('id', $promotion_id)->first();
        if ($promotion) {
            Promotion::where('id', $promotion_id)->delete();
        }

        return redirect(route('store.promotion.index', $store_id))
            ->with('success','You have deleted promotion successful!');;

    }

    public function addPromotion(Request $request, $store_id) {

        $store = Store::where('id', $store_id)->first();
        $statuses = [0 => 'New', 1 => 'Public', 2 => 'Un-public'];
        return View::make('admin.stores.add_promotion')
            ->with('store', $store)->with('statuses', $statuses);
    }

    public function postAddPromotion(PromotionRequest $request, $store_id) {
        $store = Store::where('id', $store_id)->first();
        $plan = $request->get('plan', 0);
        if ($store){
            $data = $request->all();
            $data['store_id'] = $store_id;
            unset($data['plan']);
            $promotion = $this->promotionRepository->bulkInsert($data);
            if ($plan == 1){
                $promotion_id = $promotion->id;
                return redirect(route('store.promotion.date', [$store_id, $promotion_id]))
                    ->with('success','You have added promotion successful!');;
            }
            return redirect(route('store.promotion.index', $store_id))
                ->with('success','You have added promotion successful!');;
        }

    }

    public function addPromotionDate(Request $request, $store_id, $promotion_id) {

        $store = Store::where('id', $store_id)->first();
        $statuses = [0 => 'New', 1 => 'Public', 2 => 'Un-public'];
        $promotion = Promotion::with(['dates'])->where('id', $promotion_id)->first();
        return View::make('admin.stores.promotion_date')
            ->with('store', $store)->with('promotion', $promotion)->with('statuses', $statuses);
    }

    public function postAddPromotionDate(PromotionDateRequest $request, $store_id, $promotion_id) {

        $store = Store::where('id', $store_id)->first();
        $promotion = Promotion::with(['dates'])->where('id', $promotion_id)->first();
        if ($store && $promotion && $promotion->store_id == $store->id) {
            $data = $request->all();
            $data['store_id'] = $store_id;
            $data['promotion_id'] = $promotion_id;
            $data['start_date'] = date( 'Y-m-d', strtotime($data['from_date']));
            $data['end_date'] = date( 'Y-m-d', strtotime($data['to_date']));
            $date = PromotionDate::create($data);
            return Json::encode(['success' => true, 'data' => $date]);
        }
        else {
            return Json::encode(['success' => false, 'errors' => ['auth' => 'Permission Denied']]);
        }
    }

    public function deletePromotionDate(Request $request, $store_id, $promotion_id, $date_id){
        $date = PromotionDate::where('id', $date_id)->first();
        if ($date->store_id == $store_id && $date->promotion_id == $promotion_id) {
            PromotionDate::where('id', $date_id)->delete();
            Session::flash('success', 'Delete Date of Promotion successful!');
            return redirect(route('store.promotion.date', [$store_id, $promotion_id]));
        }
        else {
            Session::flash('error', 'Delete Date of Promotion Failed');
        }
    }

    public function editPromotion(Request $request, $store_id, $promotion_id){
        $store = Store::where('id', $store_id)->first();
        $promotion = Promotion::where('id', $promotion_id)->first();
        return View::make('admin.stores.edit_promotion')
            ->with('store', $store)->with('promotion', $promotion);
    }

    public function postUpdatePromotion(Request $request, $store_id, $promotion_id) {
        $store = Store::where('id', $store_id)->first();
        $promotion = Promotion::where('id', $promotion_id)->first();
        $data = $request->all();
        $data['logo'] = $promotion['logo'];
        unset($data['_token']);
        Promotion::where('id', $promotion_id)->update($data);
        return redirect(route('store.promotion.index', $store_id))
            ->with('success','You have updated promotion successful!');
    }
}

