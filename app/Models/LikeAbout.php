<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeAbout extends Model
{
    protected $table = 'like_abouts';
    public $timestamps = true;
    protected $fillable = ['id', 'about_id', 'device_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function about(){
        return $this->belongsTo('App\Models\About');
    }

}
