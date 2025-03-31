<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'comment_name', 'comment_info', 'comment_date', 'comment_book_id',
        'comment_status', 'comment_parent_comment'
    ];
    protected $primaryKey = 'comment_id';
    protected $table = 'tbl_comment';

    public function book(){
        return $this->belongsTo('App\Models\Book','comment_book_id');
    }

    public function rating(){
        return $this->hasOne('App\Models\Rating','comment_id');
    }
}
