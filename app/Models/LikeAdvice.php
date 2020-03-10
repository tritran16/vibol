<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikeAdvice extends Model
{
    protected $table = 'like_advices';
    public $timestamps = true;
    protected $fillable = ['id', 'advice_id', 'device_id', 'status'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advice(){
        return $this->belongsTo('App\Models\Advice');
    }

}
