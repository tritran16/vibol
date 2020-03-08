<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharePge extends Model
{
    protected $table = 'share_pages';
    public $timestamps = true;

    protected $fillable = ['id', 'name','url', 'status'];
}
