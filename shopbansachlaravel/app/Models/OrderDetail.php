<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'order_id', 'book_id','book_name','book_price','book_sale_quantity','created_at'
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_detail';

    public function book(){
        return $this->belongsTo('App\Models\Book','book_id');
    }
    public function order(){
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
