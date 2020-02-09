<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $table = 'news';
    public $timestamps = true;
    protected $fillable = ['title', 'short_desc', 'image', 'category_id', 'thumbnail', 'author',
        'content', 'source', 'status', 'published_date', 'likes', 'views'];

    public function category(){
        return $this->belongsTo('App\Models\NewsCategory');
    }
}
