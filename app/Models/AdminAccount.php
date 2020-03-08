<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    protected $table = 'admin_accounts';
    public $timestamps = true;

    protected $fillable = ['id', 'name','account_id', 'account_name', 'account_link', 'status'];
}
