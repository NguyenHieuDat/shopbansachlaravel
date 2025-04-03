<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;

class AuthorController extends Controller
{
    //Hàm admin

    public function check_login(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_author(){
        $this->check_login();
        return view('admin.author.add_author');
    }

    public function all_author(){
        $this->check_login();
        $all_author = DB::table('tbl_author')->get();
        $manager_author = view('admin.author.all_author')->with('all_author',$all_author);
        return view('admin_layout')->with('admin.author.all_author',$manager_author);
    }

    public function save_author(Request $request){
        $this->check_login();

        $data = array();
        $data['author_name'] = $request->author_name;
        $data['author_description'] = $request->author_description;
        $data['author_keywords'] = $request->author_keywords;
        $image = $request->file('author_image');
        if ($request->hasFile('author_image')) {
            $image = $request->file('author_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $image->move('public/upload/author',$imageName);
            $data['author_image'] = $imageName;
        }
        DB::table('tbl_author')->insert($data);
        Session::put('message','Thêm tác giả thành công!');
        return Redirect::to('add_author');
    }

    public function edit_author($aut_id){
        $this->check_login();
        $edit_author = DB::table('tbl_author')->where('author_id',$aut_id)->get();
        $manager_author = view('admin.author.edit_author')->with('edit_author',$edit_author);
        return view('admin_layout')->with('admin.author.edit_author',$manager_author);
    }

    public function update_author(Request $request,$aut_id){
        $this->check_login();

        $data = array();
        $data['author_name'] = $request->author_name;
        $data['author_description'] = $request->author_description;
        $data['author_keywords'] = $request->author_keywords;

        $author = DB::table('tbl_author')->where('author_id', $aut_id)->first();
        $old_image = $author->author_image;
        $image = $request->file('author_image');
        if ($request->hasFile('author_image')) {
            $image = $request->file('author_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();

            $old_image_path = 'public/upload/author/' . $old_image;
            if (file_exists($old_image_path) && !empty($old_image)){
                unlink($old_image_path);
            }
            $image->move('public/upload/author',$imageName);
            $data['author_image'] = $imageName;
        }
        DB::table('tbl_author')->where('author_id',$aut_id)->update($data);
        Session::put('message','Sửa tác giả thành công!');
        return Redirect::to('all_author');
    }

    public function delete_author($aut_id){
        $this->check_login();
        $author = DB::table('tbl_author')->where('author_id', $aut_id)->first();

        if ($author) {
            $image_path = 'public/upload/author/' .($author->author_image);

            // Kiểm tra nếu file tồn tại thì xóa
            if (file_exists($image_path)) {
            unlink($image_path);
            }
        DB::table('tbl_author')->where('author_id',$aut_id)->delete();
        Session::put('message','Xóa tác giả thành công!');
        return Redirect::to('all_author');
        }
    }

    //Hàm user

    public function author_home(Request $request,$author_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $author_by_id = DB::table('tbl_book')->where('book_status','1')->join('tbl_author','tbl_book.author_id','=','tbl_author.author_id')
        ->where('tbl_book.author_id',$author_id)->get();

        $author_name_show = DB::table('tbl_author')->where('tbl_author.author_id',$author_id)->limit(1)->get();

        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();
        if (!$author_by_id->isEmpty()) {
            foreach($author_by_id as $key => $seo_value){
                $meta_desc = $seo_value->author_description ?? '';
                $meta_keywords = $seo_value->author_keywords ?? '';
                $meta_title = $seo_value->author_name ?? '';
                break;
            }
        }

        foreach ($author_by_id as $book) {
            $rating = Rating::where('book_id', $book->book_id)->avg('rating');
            $book->avgRating = $rating !== null ? round($rating, 1) : 0;
            $book->totalreview = Rating::where('book_id', $book->book_id)->count();
        }

        return view('pages.author.show_author')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('author_by_id',$author_by_id)->with('author_name_show',$author_name_show)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
