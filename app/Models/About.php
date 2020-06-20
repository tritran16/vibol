<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';
    protected $fillable = ['video_link', 'content', 'image'];
    public $timestamps = true;
}
