<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'customer_id', 'shipping_name', 'shipping_email', 'shipping_phone',
        'shipping_address', 'shipping_city', 'shipping_note'
    ];
    protected $primaryKey = 'shipping_id';
    protected $table = 'tbl_shipping';
}
