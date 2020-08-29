<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{

    protected $table = 'educations';
    public $timestamps = true;

    protected $fillable = ['id', 'name', 'image', 'link', 'description'];


}
