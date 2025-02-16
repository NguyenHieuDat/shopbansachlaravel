<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'gallery_name', 'gallery_image', 'book_id'
    ];
    protected $primaryKey = 'gallery_id';
    protected $table = 'tbl_gallerry';
}
