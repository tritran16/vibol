<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    protected $table = 'bank_accounts';
    public $timestamps = true;

    protected $fillable = ['id', 'name', 'account', 'owner', 'logo', 'pdf_file', 'description_en', 'description_kh'];


}
