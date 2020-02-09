<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'books';
    public $timestamps = false;

    protected $fillable = ['name', 'category_id' , 'filename', 'link' ,'description', 'status', 'likes', 'views'];

    protected $hidden = ['deleted_at'];

    public function category(){
        return $this->belongsTo('App\Models\BookCategory');
    }
}
