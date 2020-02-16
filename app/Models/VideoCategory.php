<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoCategory extends Model
{
    use SoftDeletes;
    protected $table = 'video_categories';
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
    protected  $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
