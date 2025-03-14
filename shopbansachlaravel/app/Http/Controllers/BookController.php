<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\GalleryModel;
use Session;
use File;
use Illuminate\Support\Facades\Redirect;
session_start();

class BookController extends Controller
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

    public function add_book(){
        $this->check_login();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        return view('admin.book.add_book')->with('cate_product',$cate_product)->with('author',$author)->with('publisher',$publisher);
    }

    public function all_book(){
        $this->check_login();
        $all_book = DB::table('tbl_book')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->join('tbl_publisher','tbl_publisher.publisher_id','=','tbl_book.publisher_id')->orderby('tbl_book.book_id','desc')->get();
        $manager_book = view('admin.book.all_book')->with('all_book',$all_book);
        return view('admin_layout')->with('admin.book.all_book',$manager_book);
    }

    public function save_book(Request $request){
        $this->check_login();

        $data = array();
        $data['book_name'] = $request->book_name;
        $data['category_id'] = $request->category;
        $data['author_id'] = $request->author;
        $data['publisher_id'] = $request->publisher;
        $data['book_language'] = $request->book_language;
        $data['book_year'] = $request->book_year;
        $data['book_page'] = $request->book_page;
        $data['book_quantity'] = $request->book_quantity;
        $data['book_price'] = $request->book_price;
        $data['book_status'] = $request->book_status;
        $data['book_description'] = $request->book_description;
        $data['book_keywords'] = $request->book_keywords;
        $image = $request->file('book_image');
        $path = 'public/upload/book/';
        $path_gallery = 'public/upload/gallery/';
        if ($request->hasFile('book_image')) {
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $newimage = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();  //tránh trường hợp ghi đè ảnh do trùng tên file
            // Di chuyển ảnh vào thư mục public/upload/book/
            $image->move($path,$newimage);
            File::copy($path.$newimage,$path_gallery.$newimage);
            // Lưu đường dẫn ảnh vào database
            $data['book_image'] = $newimage;
            
        }
        $book_id = DB::table('tbl_book')->insertGetId($data);
        $gallery = new GalleryModel;
        $gallery->gallery_image = $newimage;
        $gallery->gallery_name = $newimage;
        $gallery->book_id = $book_id;
        $gallery->save();

        Session::put('message','Thêm sách thành công!');
        return Redirect::to('add_book');
    }

    public function edit_book($books_id){
        $this->check_login();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $edit_book = DB::table('tbl_book')->where('book_id',$books_id)->get();
        $manager_book = view('admin.book.edit_book')->with('edit_book',$edit_book)->with('cate_product',$cate_product)
        ->with('author',$author)->with('publisher',$publisher);
        return view('admin_layout')->with('admin.book.edit_book',$manager_book);
    }

    public function active_book($books_id){
        $this->check_login();
        DB::table('tbl_book')->where('book_id',$books_id)->update(['book_status'=>0]);
        Session::put('message','Kích hoạt trạng thái hết hàng');
        return Redirect::to('all_book');
    }

    public function unactive_book($books_id){
        $this->check_login();
        DB::table('tbl_book')->where('book_id',$books_id)->update(['book_status'=>1]);
        Session::put('message','Kích hoạt trạng thái còn hàng');
        return Redirect::to('all_book');
    }

    public function update_book(Request $request,$books_id){
        $this->check_login();

        $data = array();
        $data['book_name'] = $request->book_name;
        $data['category_id'] = $request->category;
        $data['author_id'] = $request->author;
        $data['publisher_id'] = $request->publisher;
        $data['book_language'] = $request->book_language;
        $data['book_year'] = $request->book_year;
        $data['book_page'] = $request->book_page;
        $data['book_quantity'] = $request->book_quantity;
        $data['book_price'] = $request->book_price;
        $data['book_status'] = $request->book_status;
        $data['book_description'] = $request->book_description;
        $data['book_keywords'] = $request->book_keywords;
        $image = $request->file('book_image');
        if ($request->hasFile('book_image')) {
            $image = $request->file('book_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();  //tránh trường hợp ghi đè ảnh do trùng tên file
            // Di chuyển ảnh vào thư mục public/upload/book/
            $image->move('public/upload/book',$imageName);
            
            // Lưu đường dẫn ảnh vào database
            $data['book_image'] = $imageName;
            DB::table('tbl_book')->where('book_id',$books_id)->update($data);
            Session::put('message','Sửa sách thành công!');
            return Redirect::to('all_book');
        }

        DB::table('tbl_book')->where('book_id',$books_id)->update($data);
        Session::put('message','Sửa sách thành công!');
        return Redirect::to('all_book');
    }

    public function delete_book($books_id){
        $this->check_login();
        $book = DB::table('tbl_book')->where('book_id', $books_id)->first();

        if ($book) {
            $image_path = base_path('public/upload/book/' .($book->book_image));
            if (file_exists($image_path)) {
            unlink($image_path);
            }
        DB::table('tbl_book')->where('book_id',$books_id)->delete();
        Session::put('message','Xóa sách thành công!');
        return Redirect::to('all_book');
        }
    }

    //Ham user

    public function book_detail(Request $request,$books_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $book_detail = DB::table('tbl_book')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->join('tbl_publisher','tbl_publisher.publisher_id','=','tbl_book.publisher_id')
        ->where('tbl_book.book_id',$books_id)->get();

        foreach($book_detail as $key => $details){
            $category_id = $details->category_id;
        }
        
        $book_related = DB::table('tbl_book')->where('book_status','1')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->join('tbl_publisher','tbl_publisher.publisher_id','=','tbl_book.publisher_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_book.book_id',[$books_id])->get();

        foreach($book_detail as $key => $value){
            $book_id = $value->book_id;
        }
        $gallery = GalleryModel::where('book_id',$book_id)->get();

        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();
        if (!$book_detail->isEmpty()) {
            foreach($book_detail as $key => $seo_value){
                $meta_desc = $seo_value->book_description ?? '';
                $meta_keywords = $seo_value->book_keywords ?? '';
                $meta_title = $seo_value->book_name ?? '';
                break;
            }
        }
        return view('pages.book.show_book_detail')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('book_detail',$book_detail)->with('gallery',$gallery)
        ->with('related',$book_related)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
