<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategory extends Model
{
    use SoftDeletes;
    protected $table = 'news_categories';
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
