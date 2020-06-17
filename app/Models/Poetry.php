<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poetry extends Model
{
    use SoftDeletes;
    protected $table = 'poetries';
    public $timestamps = true;
    protected $fillable = ['id', 'title', 'thumbnail', 'author', 'content', 'source', 'video_link', 'status',
        'likes', 'views',  'is_hot', 'created_at', 'updated_at'];

    protected $hidden = ['deleted_at'];



    public function notifications()
    {
        return $this->morphToMany('App\Models\Notification', 'notification');
    }
}
