<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Http\Requests\BookCategoryRequest;
use App\Models\BankAccount;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Video;
use App\Repositories\BankAccountRepository;
use App\Repositories\BookCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BankAccountsController extends Controller
{
    private $bankAccountsRepository;

    public function __construct(BankAccountRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->bankAccountsRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = $this->bankAccountsRepository->all();
        return view('admin.bank_accounts.index')->with('bank_accounts', $bank_accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank_accounts.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountRequest $request)
    {
        if (!$request->hasFile('logo')) {
            return redirect(route('bank_accounts.create'))
                ->withErrors([__('Logo BankAccount is required')])
                ->withInput();
        }

        if ($request->file('logo') && $request->file('pdf_file')){
            $image = $request->file('logo');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('bank_accounts/logo/'.  $img_name, File::get($image));

            $pdf = $request->file('pdf_file');
            $pdf_name  = urlencode($pdf->getClientOriginalName()) ;
            Storage::disk('public')->put('bank_accounts/pdf/'.  $pdf_name, File::get($pdf));

            $data = array_merge($request->only(['name', 'account', 'owner', 'description_en', 'description_kh']),
                [ 'logo' => 'storage/bank_accounts/logo/'.$img_name, 'pdf_file' => 'storage/bank_accounts/pdf/'.$pdf_name]);
            $bank_account = BankAccount::create($data);
        }

        return redirect(route('bank_accounts.index'))->with('success', 'Created BankAccount successfully!');//

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
        $bank_account = BankAccount::findOrFail($id);
        return view('admin.bank_accounts.edit')->with('bank_account', $bank_account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankAccountRequest $request, $id)
    {
        $bank_account = BankAccount::findOrFail($id);

        BankAccount::where('id', $id)->update($request->only(['type', 'title', 'content']));
        if ($request->file('logo')){
            $image = $request->file('logo');
            $img_name  = urlencode($image->getClientOriginalName()) ;
            Storage::disk('public')->put('bank_accounts/logo/'.  $img_name, File::get($image));
            BankAccount::where('id', $bank_account->id)->update([ 'logo' => 'storage/bank_accounts/logo/'.$img_name]);
        }
        if ($request->file('pdf_file')){
            $pdf = $request->file('pdf_file');
            $pdf_name  = urlencode($pdf->getClientOriginalName()) ;
            Storage::disk('public')->put('bank_accounts/pdf/'.  $pdf_name, File::get($pdf));
            BankAccount::where('id', $bank_account->id)->update([ 'pdf_file' => 'storage/bank_accounts/pdf/'.$pdf_name]);
        }
        return redirect(route('bank_accounts.index'))->with('success', 'Update BankAccount successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BankAccount::where('id', $id)->delete();
        return redirect(route('bank_accounts.index'))->with('success', 'Deleted BankAccount Successful!');

    }
}
