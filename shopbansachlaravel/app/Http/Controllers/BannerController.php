<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
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

    public function all_banner(){
        $all_banner = Banner::orderby('banner_id','desc')->get();
        return view('admin.banner.all_banner')->with(compact('all_banner'));
    }

    public function active_banner($banner_id){
        $this->check_login();
        Banner::where('banner_id', $banner_id)->update(['banner_status' => 0]);
        Session::put('message', 'Kích hoạt trạng thái không hiển thị');
        return Redirect::to('all_banner');
    }
    
    public function unactive_banner($banner_id){
        $this->check_login();
        Banner::where('banner_id', $banner_id)->update(['banner_status' => 1]);
        Session::put('message', 'Kích hoạt trạng thái hiển thị');
        return Redirect::to('all_banner');
    }

    public function add_banner(){
        $this->check_login();
        return view('admin.banner.add_banner');
    }

    public function save_banner(Request $request){
        $this->check_login();
        $data = [
            'banner_name' => $request->banner_name,
            'banner_description' => $request->banner_description,
            'banner_status' => $request->banner_status,
        ];
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.', $getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $image->move('public/upload/banner', $imageName);
            $data['banner_image'] = $imageName;
        } else {
            $data['banner_image'] = '';
        }
        Banner::create($data);

        Session::put('message', 'Thêm banner thành công!');
        return Redirect::to('add_banner');
    }

    public function edit_banner($banner_id){
        $this->check_login();
        $edit_banner = Banner::where('banner_id', $banner_id)->get();
        return view('admin.banner.edit_banner')->with('edit_banner', $edit_banner);
    }

    public function update_banner(Request $request,$banner_id){
        $this->check_login();
        $banner = Banner::find($banner_id);

        if (!$banner) {
            Session::put('message', 'Banner không tồn tại!');
            return Redirect::to('all_banner');
        }

        $banner->banner_name = $request->banner_name;
        $banner->banner_description = $request->banner_description;
        $banner->banner_status = $request->banner_status;

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.', $getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $image->move('public/upload/banner', $imageName);
            if ($banner->banner_image && file_exists(public_path('upload/banner/' . $banner->banner_image))) {
                unlink(public_path('upload/banner/' . $banner->banner_image));
            }
            $banner->banner_image = $imageName;
        }
        $banner->save();

        Session::put('message', 'Cập nhật banner thành công!');
        return Redirect::to('all_banner');
    }

    public function delete_banner($banner_id){
        $this->check_login();
        $banner = Banner::find($banner_id);

        if ($banner) {
            $image_path = public_path('upload/banner/' . $banner->banner_image);
            if ($banner->banner_image && file_exists($image_path)) {
                unlink($image_path);
            }
            $banner->delete();

            Session::put('message', 'Xóa banner thành công!');
            return Redirect::to('all_banner');
        }

        Session::put('message', 'Banner không tồn tại!');
        return Redirect::to('all_banner');
    }
}
