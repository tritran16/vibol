<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeBook extends Model
{
    protected $table = 'like_books';
    public $timestamps = true;
    protected $fillable = ['id', 'book_id', 'device_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(){
        return $this->belongsTo('App\Models\Book');
    }

}
