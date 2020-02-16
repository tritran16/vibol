<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class NewsCategoryTranslation extends Model
{
    protected $fillable = ['name', 'description'];
    public $timestamps = false;
}
