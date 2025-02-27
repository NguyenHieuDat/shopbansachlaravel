<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'order_id', 'book_id','book_name','book_price','book_sale_quantity'
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_detail';
}
