<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'author_name', 'author_image', 'author_description', 'author_keywords'
    ];
    protected $primaryKey = 'author_id';
    protected $table = 'tbl_author';
}
