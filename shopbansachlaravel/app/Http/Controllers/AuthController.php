<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth_register(){
        return view('admin.auth.auth_register');
    }

    public function admin_authregister(Request $request){
        $request->validate([
            'admin_name' => 'required|max:255',
            'admin_phone' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);
        $data = $request->all();

        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = bcrypt($data['admin_password']);
        $admin->save();

        return redirect('/auth_register')->with('message','Đăng ký thành công');
    }

    public function auth_login(){
        return view('admin.auth.auth_login');
    }

    public function admin_authlogin(Request $request){
        $request->validate([
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);

        $credentials = [
            'admin_email' => $request->admin_email,
            'password' => $request->admin_password,
        ];

        if(Auth::guard('web')->attempt($credentials)){
            return redirect('/dashboard')->with('message', 'Đăng nhập thành công!');
        } else {
            return redirect('/auth_login')->with('error', 'Email hoặc mật khẩu không chính xác!');
        }
    }

    public function auth_logout(){
        Auth::logout();
        return redirect('/auth_login');
    }
}
