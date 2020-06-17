<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikePoetry extends Model
{
    protected $table = 'like_poetry';
    public $timestamps = true;
    protected $fillable = ['id', 'poetry_id', 'device_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poetry(){
        return $this->belongsTo('App\Models\Poetry');
    }

}
