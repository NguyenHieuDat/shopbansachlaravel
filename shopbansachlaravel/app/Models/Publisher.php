<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'publisher_name', 'publisher_description', 'publisher_keywords'
    ];
    protected $primaryKey = 'publisher_id';
    protected $table = 'tbl_publisher';
}
