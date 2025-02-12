<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class AuthorController extends Controller
{
    public function add_author(){
        return view('admin.add_author');
    }

    public function all_author(){
        $all_author = DB::table('tbl_author')->get();
        $manager_author = view('admin.all_author')->with('all_author',$all_author);
        return view('admin_layout')->with('admin.all_author',$manager_author);
    }

    public function save_author(Request $request){
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author_description' => 'nullable|string',
        ]);

        $data = array();
        $data['author_name'] = $request->author_name;
        $data['author_description'] = $request->author_description;
        $image = $request->file('author_image');
        if ($request->hasFile('author_image')) {
            $image = $request->file('author_image');
            $imageName = time() . '_' . $image->getClientOriginalExtension();  //tránh trường hợp ghi đè ảnh do trùng tên file
            // Di chuyển ảnh vào thư mục public/upload/author/
            $image->move('public/upload/author',$imageName);
            // Lưu đường dẫn ảnh vào database
            $data['author_image'] = $imageName;
            DB::table('tbl_author')->insert($data);
            Session::put('message','Thêm tác giả thành công!');
            return Redirect::to('add_author');
        }

        DB::table('tbl_author')->insert($data);
        Session::put('message','Thêm tác giả thành công!');
        return Redirect::to('all_author');
    }

    public function edit_author($aut_id){
        $edit_author = DB::table('tbl_author')->where('author_id',$aut_id)->get();
        $manager_author = view('admin.edit_author')->with('edit_author',$edit_author);
        return view('admin_layout')->with('admin.edit_author',$manager_author);
    }

    public function update_author(Request $request,$aut_id){
        $data = array();
        $data['author_name'] = $request->author_name;
        $data['author_description'] = $request->author_description;
        $image = $request->file('author_image');
        if ($request->hasFile('author_image')) {
            $image = $request->file('author_image');
            $imageName = time() . '_' . $image->getClientOriginalExtension();  //tránh trường hợp ghi đè ảnh do trùng tên file
            // Di chuyển ảnh vào thư mục public/upload/author/
            $image->move('public/upload/author',$imageName);
            // Lưu đường dẫn ảnh vào database
            $data['author_image'] = $imageName;
            DB::table('tbl_author')->where('author_id',$aut_id)->update($data);
            Session::put('message','Sửa tác giả thành công!');
            return Redirect::to('all_author');
        }

        DB::table('tbl_author')->where('author_id',$aut_id)->update($data);
        Session::put('message','Sửa tác giả thành công!');
        return Redirect::to('all_author');
    }

    public function delete_author($aut_id){
        DB::table('tbl_author')->where('author_id',$aut_id)->delete();
        Session::put('message','Xóa tác giả thành công!');
        return Redirect::to('all_author');
    }
}
