<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = ['id', 'title', 'body', 'notification_type', 'notification_id', 'send_to'];

    public function notification()
    {
        return $this->morphTo();
    }

    public function news()
    {
        return $this->morphedByMany('App\Models\News', 'notification');
    }

    public function books()
    {
        return $this->morphedByMany('App\Models\Book', 'notification');
    }

    public function videos()
    {
        return $this->morphedByMany('App\Models\Video', 'notification');
    }
    public function daily_advices()
    {
        return $this->morphedByMany('App\Models\DailyAdvice', 'notification');
    }
}
