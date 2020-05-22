<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';
    protected $fillable = ['key', 'title', 'content', 'image'];
    public $timestamps = true;
}
