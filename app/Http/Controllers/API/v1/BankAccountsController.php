<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AboutCollection;
use App\Http\Resources\BankAccountCollection;
use App\Http\Resources\EducationCollection;
use App\Models\BankAccount;
use App\Models\Education;
use Illuminate\Http\Request;

class BankAccountsController extends ApiController
{
    public function index(Request $request) {

        $bank_accounts = BankAccount::paginate();
        return $this->successResponse(new BankAccountCollection($bank_accounts));
    }






}
