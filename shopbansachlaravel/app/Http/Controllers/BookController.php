<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BookController extends Controller
{
    public function add_book(){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        return view('admin.add_book')->with('cate_product',$cate_product)->with('author',$author)->with('publisher',$publisher);
    }

    public function all_book(){
        $all_book = DB::table('tbl_book')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_book.category_id')
        ->join('tbl_author','tbl_author.author_id','=','tbl_book.author_id')
        ->join('tbl_publisher','tbl_publisher.publisher_id','=','tbl_book.publisher_id')->orderby('tbl_book.book_id','desc')->get();
        $manager_book = view('admin.all_book')->with('all_book',$all_book);
        return view('admin_layout')->with('admin.all_book',$manager_book);
    }

    public function save_book(Request $request){
        $data = array();
        $data['book_name'] = $request->book_name;
        $data['category_id'] = $request->category;
        $data['author_id'] = $request->author;
        $data['publisher_id'] = $request->publisher;
        $data['book_language'] = $request->book_language;
        $data['book_year'] = $request->book_year;
        $data['book_page'] = $request->book_page;
        $data['book_price'] = $request->book_price;
        $data['book_status'] = $request->book_status;
        $data['book_description'] = $request->book_description;
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
            DB::table('tbl_book')->insert($data);
            Session::put('message','Thêm sách thành công!');
            return Redirect::to('add_book');
        }

        $data['book_image'] = '';
        DB::table('tbl_book')->insert($data);
        Session::put('message','Thêm sách thành công!');
        return Redirect::to('add_book');
    }

    public function edit_book($books_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $edit_book = DB::table('tbl_book')->where('book_id',$books_id)->get();
        $manager_book = view('admin.edit_book')->with('edit_book',$edit_book)->with('cate_product',$cate_product)
        ->with('author',$author)->with('publisher',$publisher);
        return view('admin_layout')->with('admin.edit_book',$manager_book);
    }

    public function active_book($books_id){
        DB::table('tbl_book')->where('book_id',$books_id)->update(['book_status'=>0]);
        Session::put('message','Kích hoạt trạng thái hết hàng');
        return Redirect::to('all_book');
    }

    public function unactive_book($books_id){
        DB::table('tbl_book')->where('book_id',$books_id)->update(['book_status'=>1]);
        Session::put('message','Kích hoạt trạng thái còn hàng');
        return Redirect::to('all_book');
    }

    public function update_book(Request $request,$books_id){
        $data = array();
        $data['book_name'] = $request->book_name;
        $data['category_id'] = $request->category;
        $data['author_id'] = $request->author;
        $data['publisher_id'] = $request->publisher;
        $data['book_language'] = $request->book_language;
        $data['book_year'] = $request->book_year;
        $data['book_page'] = $request->book_page;
        $data['book_price'] = $request->book_price;
        $data['book_status'] = $request->book_status;
        $data['book_description'] = $request->book_description;
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
        // Lấy thông tin tác giả từ database
        $book = DB::table('tbl_book')->where('book_id', $books_id)->first();

        // Kiểm tra xem ảnh có tồn tại không, nếu có thì xóa
        if ($book) {
        // Đường dẫn trực tiếp từ thư mục public
            $image_path = 'public/upload/book/' .($book->book_image);

        // Kiểm tra nếu file tồn tại thì xóa
            if (file_exists($image_path)) {
            unlink($image_path);
            }
        DB::table('tbl_book')->where('book_id',$books_id)->delete();
        Session::put('message','Xóa sách thành công!');
        return Redirect::to('all_book');
        }
    }
}
