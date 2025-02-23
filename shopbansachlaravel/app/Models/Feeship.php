<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_price'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    public function city(){
        return $this->belongsTo('App\Models\City','fee_matp');
    }
    public function province(){
        return $this->belongsTo('App\Models\Province','fee_maqh');
    }
    public function ward(){
        return $this->belongsTo('App\Models\Ward','fee_xaid');
    }
}
