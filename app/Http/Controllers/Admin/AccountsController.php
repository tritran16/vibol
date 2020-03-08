<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\AdminAccount;
use App\Repositories\AdminAccountRepository;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    private $adminAccountRepository;

    public function __construct(AdminAccountRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->adminAccountRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = $this->adminAccountRepository->all();
        return view('admin.accounts.index')->with('accounts', $accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        AdminAccount::create($request->only(['name', 'account_name', 'account_id', 'account_link',  'status']));

        return redirect(route('admin_accounts.index'))->with('success', 'Created admin account successfully!');//
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
        $account = AdminAccount::findOrFail($id);
        return view('admin.accounts.edit')->with('account', $account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request, $id)
    {
        $account = AdminAccount::findOrFail($id);
        AdminAccount::where('id', $id)->update($request->only(['name', 'account_name', 'account_id', 'account_link',  'status']));
        return redirect(route('admin_accounts.index'))->with('success', 'Update Admin Account successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AdminAccount::where('id', $id)->delete();
        return redirect(route('admin_accounts.index'))->with('success', 'Deleted Admin Account Successful!');
    }
}
