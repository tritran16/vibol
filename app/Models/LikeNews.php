<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeNews extends Model
{
    protected $table = 'like_news';
    public $timestamps = true;
    protected $fillable = ['id', 'news_id', 'device_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news(){
        return $this->belongsTo('App\Models\News');
    }

}
