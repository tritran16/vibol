<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class NewsTranslation extends Model
{
    protected $fillable = ['title', 'short_desc', 'content'];
    public $timestamps = false;
}
