<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\GalleryModel;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class GalleryController extends Controller
{
    //Ham admin

    public function check_login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_gallery($book_id){
        $gal_id = $book_id;
        return view('admin.gallery.add_gallery')->with(compact('gal_id'));
    }

    public function select_gallery(Request $request){
        $book_id = $request->gal_id;
        $gallery = GalleryModel::where('book_id',$book_id)->get();
        $gallery_count = $gallery->count();
        $output = '<table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Thứ tự ảnh</th>
              <th>Tên hình ảnh</th>
              <th>Hình ảnh</th>
              <th>Quản lý</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
          ';
        if($gallery_count>0){
            $i = 0;
            foreach($gallery as $key => $gal){
                $i++;
                $output.='<tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>'.$i.'</td>
              <td>'.$gal->gallery_name.'</td>
              <td><img src="'.url('public/upload/gallery/'.$gal->gallery_image).'" height="150" width="150"></td>
              <td>
                <a data-gal_id="'.$gal->gallery_id.'" onclick="return confirm(\'Bạn chắc chắn muốn xóa chứ?\')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>';
            }
            }else{
                $output.='<tr>
                <td colspan="4">Sản phẩm này chưa có thư viện ảnh</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;  
        }

        public function insert_gallery(Request $request,$gal_id){
            $get_image = $request->file('file');
            if($get_image){
                foreach($get_image as $image){
                    $getimageName = $image->getClientOriginalName();
                    $nameimage = current(explode('.',$getimageName));
                    $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();  //tránh trường hợp ghi đè ảnh do trùng tên file
                    // Di chuyển ảnh vào thư mục public/upload/book/
                    $image->move('public/upload/gallery',$imageName);
                    $gallery = new GalleryModel();
                    $gallery->gallery_name = $imageName;
                    $gallery->gallery_image = $imageName;
                    $gallery->book_id = $gal_id;
                    $gallery->save();
                }
            }
            Session::put('message','Thêm ảnh vào thư viện thành công!');
            return redirect()->back();
                
        }
    }