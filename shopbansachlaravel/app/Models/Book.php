<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'book_name', 'category_id', 'author_id', 'publisher_id', 
        'book_image', 'book_language', 'book_year', 'book_page', 
        'book_cost', 'book_price', 'book_quantity', 'book_sold', 
        'book_status', 'book_description', 'book_keywords'
    ];
    protected $primaryKey = 'book_id';
    protected $table = 'tbl_book';

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function author(){
        return $this->belongsTo('App\Models\Author','author_id');
    }
    public function publisher(){
        return $this->belongsTo('App\Models\Publisher','publisher_id');
    }
    public function comment(){
        return $this->hasMany('App\Models\Comment');
    }
}
