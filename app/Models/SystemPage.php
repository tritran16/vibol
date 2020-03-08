<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemPage extends Model
{
    protected $table = 'system_pages';
    public $timestamps = true;

    protected $fillable = ['id', 'name', 'url', 'status'];
}
