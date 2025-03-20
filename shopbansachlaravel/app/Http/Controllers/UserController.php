<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Session;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::with('roles')->orderBy('admin_id','DESC')->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
    }

    public function add_users(){
        return view('admin.users.add_users');
    }

    public function assign_roles(Request $request){
        if(Auth::id()==$request->admin_id){
            return redirect()->back()->with('message','Bạn không được tự phân quyền chính mình!');
        }
        $user = Admin::where('admin_email',$request['admin_email'])->first();
        $user->roles()->detach();

        if($request['user_role']){
           $user->roles()->attach(Roles::where('role_name','user')->first());     
        }
        if($request['admin_role']){
           $user->roles()->attach(Roles::where('role_name','admin')->first());     
        }
        return redirect()->back()->with('message','Phân quyền thành công');
    }

    public function delete_user_roles($admin_id){
        if(Auth::id()==$admin_id){
            return redirect()->back()->with('message','Bạn không được tự xóa quyền của mình!');
        }
        $admin = Admin::find($admin_id);
        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xóa thành công');
    }

    public function store_users(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        $admin->roles()->attach(Roles::where('role_name','user')->first());
        Session::put('message','Thêm users thành công');
        return Redirect::to('users');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
