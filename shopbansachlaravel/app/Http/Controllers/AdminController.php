<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Login;
use App\Models\SocialModel;
use Socialite;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function check_login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function index(){
        return view('admin_login');
    }

    public function dashboard_layout(){
        $this->check_login();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){
        $data = $request->all();
        $admin_email = $data['admin_email'];
        $admin_password = $data['admin_password'];

        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($login){
            Session::put('admin_name',$login->admin_name);
            Session::put('admin_id',$login->admin_id);
            return Redirect::to('/dashboard');
            }
        else{
            Session::put('fail_message','Sai email hoặc mật khẩu!');
            return Redirect::to('/admin');
            }
        }

    public function logout(){
        $this->check_login();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

    // public function login_fb(){
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function callback_fb(){
    //     $provider = Socialite::driver('facebook')->user();
    //     $account = SocialModel::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
    //     if($account){
    //         //login in vao trang quan tri  
    //         $account_name = Login::where('admin_id',$account->user)->first();
    //         Session::put('admin_name',$account_name->admin_name);
    //         Session::put('admin_id',$account_name->admin_id);
    //         return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     }else{

    //         $fb_acc = new SocialModel([
    //             'provider_user_id' => $provider->getId(),
    //             'provider' => 'facebook'
    //         ]);

    //         $orang = Login::where('admin_email',$provider->getEmail())->first();

    //         if(!$orang){
    //             $orang = Login::create([
    //                 'admin_name' => $provider->getName(),
    //                 'admin_email' => $provider->getEmail(),
    //                 'admin_password' => '',
    //                 'admin_phone' => ''

    //             ]);
    //         }
    //         $fb_acc->login()->associate($orang);
    //         $fb_acc->save();

    //         Session::put('admin_name',$orang->admin_name);
    //         Session::put('admin_id',$orang->admin_id);
    //         return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    //     } 
    // }


}
