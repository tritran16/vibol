<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyAdvice extends Model
{
    use SoftDeletes;
    protected $table = 'daily_advices';
    public $timestamps = true;

    protected $fillable = ['author', 'advice', 'content', 'type', 'video', 'image' ,'text_position', 'status', 'likes', 'dislikes'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function notifications()
    {
        return $this->morphToMany('App\Notification', 'notification');
    }
}
