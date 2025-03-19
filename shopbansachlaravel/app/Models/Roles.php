<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class Roles extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'role_name'
    ];
    protected $primaryKey = 'role_id';
 	protected $table = 'tbl_roles';

 	public function admin(){
 		return $this->belongsToMany(Admin::class, 'admin_roles', 'roles_role_id', 'admin_admin_id');
 	}
}
