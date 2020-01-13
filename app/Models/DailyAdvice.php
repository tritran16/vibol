<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyAdvice extends Model
{
    use SoftDeletes;
    protected $table = 'daily_advices';
    public $timestamps = true;

    protected $fillable = ['author', 'advice', 'status'];
}
