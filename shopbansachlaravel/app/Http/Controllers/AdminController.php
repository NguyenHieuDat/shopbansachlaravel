<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Login;
use App\Models\SocialModel;
use App\Models\Statistical;
use Socialite;
use Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function check_login(){
        $admin_id = Auth::id();
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
        $admin_password = bcrypt($data['admin_password']);

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
    // public function dashboard(Request $request){
    //     $data = $request->all();
    //     $admin_email = $data['admin_email'];
    //     $admin_password = $data['admin_password'];

    //     $login = Login::where('admin_email', $admin_email)->first();

    //     if ($login && Hash::check($admin_password, $login->admin_password)) {
    //         Session::put('admin_name', $login->admin_name);
    //         Session::put('admin_id', $login->admin_id);
    //         return Redirect::to('/dashboard');
    //     } else {
    //         Session::put('fail_message', 'Sai email hoặc mật khẩu!');
    //         return Redirect::to('/admin');
    //     }
    // }

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

    public function date_filter(Request $request){
        $data = $request->all();

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistical::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','asc')->get();

        foreach($get as $key => $date){
            $chart_data[] = array(
                'period' => $date->order_date,
                'order' => $date->total_order,
                'sales' => $date->sales,
                'profit' => $date->profit,
                'quantity' => $date->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $mot_tuan = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $mot_nam = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $dau_thang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        
        if($data['dashboard_value']=='mot-tuan'){
            $get = Statistical::whereBetween('order_date',[$mot_tuan,$now])->orderBy('order_date','asc')->get();
        }elseif($data['dashboard_value']=='thang-truoc'){
            $get = Statistical::whereBetween('order_date',[$dau_thang_truoc,$cuoi_thang_truoc])->orderBy('order_date','asc')->get();
        }elseif($data['dashboard_value']=='thang-nay'){
            $get = Statistical::whereBetween('order_date',[$dau_thang_nay,$now])->orderBy('order_date','asc')->get();
        }else{
            $get = Statistical::whereBetween('order_date',[$mot_nam,$now])->orderBy('order_date','asc')->get();
        }

        foreach($get as $key => $date){
            $chart_data[] = array(
                'period' => $date->order_date,
                'order' => $date->total_order,
                'sales' => $date->sales,
                'profit' => $date->profit,
                'quantity' => $date->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
}
