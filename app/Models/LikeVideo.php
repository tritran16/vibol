<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeVideo extends Model
{
    protected $table = 'like_videos';
    public $timestamps = true;
    protected $fillable = ['id', 'video_id', 'device_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video(){
        return $this->belongsTo('App\Models\Video');
    }

}
