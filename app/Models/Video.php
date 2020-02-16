<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    protected $table = 'videos';
    public $timestamps = true;
    protected $fillable = ['id', 'title', 'thumbnail','category_id' , 'thumb', 'author', 'description', 'source', 'link', 'status',
        'likes', 'views',  'is_hot', 'created_at', 'updated_at'];

    protected $hidden = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Models\VideoCategory');
    }
}
