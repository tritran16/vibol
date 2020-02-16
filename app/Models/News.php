<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'news';
    public $timestamps = true;
    protected $fillable = ['id', 'title', 'short_desc', 'image', 'category_id', 'thumbnail', 'author',
        'content', 'source', 'status', 'published_date', 'likes', 'views', 'is_hot','created_at', 'updated_at'];
    protected $hidden = ['deleted_at'];
    public $translatedAttributes = ['title', 'short_desc', 'content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Models\NewsCategory');
    }
}
