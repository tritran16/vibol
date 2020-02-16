<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'books';
    public $timestamps = true;

    protected $fillable = ['name', 'category_id' , 'filename', 'link' ,'description', 'status', 'likes', 'views',
        'created_at', 'updated_at'];

    protected $hidden = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Models\BookCategory');
    }
}
