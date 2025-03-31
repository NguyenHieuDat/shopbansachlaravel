<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'book_id', 'comment_id', 'rating'
    ];
    protected $primaryKey = 'rating_id';
    protected $table = 'tbl_rating';

    public function comment(){
        return $this->belongsTo('App\Models\Comment','comment_id');
    }

    public function book(){
        return $this->belongsTo('App\Models\Book','book_id');
    }

    
}
