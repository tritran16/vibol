<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    protected $table = 'devices';
    public $timestamps = true;
    protected $fillable = ['device_token', 'type'];
}
