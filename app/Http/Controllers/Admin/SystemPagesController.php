<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\AdminAccount;
use App\Repositories\AdminAccountRepository;
use Illuminate\Http\Request;

class SystemPagesController extends Controller
{
    private $systemPageRepository;

    public function __construct(AdminAccountRepository $repository)
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
        $accounts = $this->systemPageRepository->all();
        return view('admin.share_pages.index')->with('accounts', $accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.share_pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        AdminAccount::create($request->only(['name', 'url',  'status']));

        return redirect(route('share_pages.index'))->with('success', 'Created System Share Page successfully!');//
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
        return view('admin.share_pages.edit')->with('account', $account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = AdminAccount::findOrFail($id);
        AdminAccount::where('id', $id)->update($request->only(['name', 'account_name', 'account_id', 'account_link',  'status']));
        return redirect(route('share_pages.index'))->with('success', 'Update System Share Page successfully!');
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
        return redirect(route('share_pages.index'))->with('success', 'Deleted System Share Page Successful!');
    }
}
