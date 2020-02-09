<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    protected $table = 'videos';
    public $timestamps = true;
    public $fillable = ['title' ,'category_id' , 'thumb', 'author', 'description', 'source', 'link', 'status',
        'likes', 'views'];
    public function category(){
        return $this->belongsTo('App\Models\VideoCategory');
    }
}
