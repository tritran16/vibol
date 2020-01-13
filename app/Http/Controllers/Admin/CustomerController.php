<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

const NUM_OF_PAGINATION = 30;

class CustomerController extends Controller
{

    private $customerRepository;
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
        $customers = Customer::paginate(NUM_OF_PAGINATION);

        return View::make('admin.customers.index')
            ->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $validated = $request->validated();

        $customer = new Customer;
        $customer->title = Input::get('name');
        $customer->content = Input::get('description');
        $customer->save();

        // redirect
        Session::flash('message', 'Created customer successfully!');
        return Redirect::to('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        // show the view and pass the customer to it
        return View::make('admin.categories.show')
            ->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);

        // show the view and pass the customer to it
        return View::make('admin.categories.edit')
            ->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerStoreRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $validated = $request->validated();

        $customer = Customer::findorfail($id);
        $customer->phone = Input::get('phone');
       // $customer->content = Input::get('description');
        $customer->save();

        // redirect
        Session::flash('message', 'Successfully updated customer!');
        return Redirect::to('admin.customer');
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
        $customer = customer::find($id);
        $customer->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the customer!');
        return Redirect::to('admin.customer');
    }
}
