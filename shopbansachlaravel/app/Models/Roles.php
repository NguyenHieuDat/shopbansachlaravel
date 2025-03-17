<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'role_name'
    ];
    protected $primaryKey = 'role_id';
 	protected $table = 'tbl_roles';

 	public function admin(){
 		return $this->belongsToMany('App\Models\Admin');
 	}
}
