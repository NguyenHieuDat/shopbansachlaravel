<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'customer_id', 'shipping_id','payment_id','total_bf',
        'coupon_code','coupon_price','feeship_price',
        'order_total','order_status','created_at'
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';
    
    public function orderdetail(){
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }
}
