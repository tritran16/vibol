<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCategory extends Model
{
    use SoftDeletes;
    protected $table = 'book_categories';
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
