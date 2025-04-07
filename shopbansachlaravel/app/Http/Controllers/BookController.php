<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\GalleryModel;
use App\Models\Comment;
use App\Models\Rating;
use Session;
use File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    //Ham admin

    public function check_login(){
        $admin_id = Auth::id();
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
            $newimage = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $image->move($path,$newimage);
            File::copy($path.$newimage,$path_gallery.$newimage);
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

        $book = DB::table('tbl_book')->where('book_id', $books_id)->first();
        $old_image = $book->book_image;
        $image = $request->file('book_image');
        if ($request->hasFile('book_image')) {
            $image = $request->file('book_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();

            $old_image_path = 'public/upload/book/' . $old_image;
            if (file_exists($old_image_path) && !empty($old_image)){
                unlink($old_image_path);
            }
            $image->move('public/upload/book',$imageName);
            $data['book_image'] = $imageName;
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
        // Lấy tất cả các ảnh gallery liên quan đến sách này
        $gallery_images = GalleryModel::where('book_id', $books_id)->get();

        // Xóa từng ảnh trong gallery nếu tồn tại
        foreach ($gallery_images as $gallery) {
            $gallery_image_path = base_path('public/upload/gallery/' . ($gallery->gallery_image));
            if (file_exists($gallery_image_path)) {
                unlink($gallery_image_path);
            }
            $gallery->delete();
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
            $product_cate = $details->category_name;
            $author_id = $details->author_id;
            $author_name = $details->author_name;
            $publisher_id = $details->publisher_id;
            $publisher_name = $details->publisher_name;
        }
        $book_related = DB::table('tbl_book')->where('book_status','1')
    ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_book.category_id')
    ->join('tbl_author', 'tbl_author.author_id', '=', 'tbl_book.author_id')
    ->join('tbl_publisher', 'tbl_publisher.publisher_id', '=', 'tbl_book.publisher_id')
    ->leftJoin('tbl_rating', 'tbl_book.book_id', '=', 'tbl_rating.book_id')
    ->where('tbl_category_product.category_id', $category_id)
    ->where('tbl_book.book_status', 1)
    ->whereNotIn('tbl_book.book_id', [$books_id])
    ->select('tbl_book.book_id', 'tbl_book.book_name', 'tbl_book.book_image', 'tbl_book.book_price', DB::raw('AVG(tbl_rating.rating) as avgRating'), DB::raw('COUNT(tbl_rating.rating) as totalreview'))
    ->groupBy('tbl_book.book_id', 'tbl_book.book_name', 'tbl_book.book_image', 'tbl_book.book_price')
    ->get();


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

        $comments = Comment::where('comment_parent_comment',null)->where('comment_book_id', $book_id)->get();
        $avgRating = Rating::where('book_id', $book_id)->avg('rating');
        $avgRating = round($avgRating, 1);
        $totalreview = Rating::where('book_id', $book_id)->count();

        return view('pages.book.show_book_detail')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('book_detail',$book_detail)->with('gallery',$gallery)
        ->with('related',$book_related)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('product_cate',$product_cate)
        ->with('category_id',$category_id)->with('publisher_id',$publisher_id)->with('publisher_name',$publisher_name)
        ->with('author_name',$author_name)->with('author_id',$author_id)->with('comments',$comments)->with('avgRating',$avgRating)
        ->with('totalreview',$totalreview);
    }

    public function load_comment(Request $request){
        $book_id = $request->book_id;
        $comment = Comment::where('comment_book_id',$book_id)->where('comment_parent_comment',null)->where('comment_status', 1)
        ->leftJoin('tbl_rating', 'tbl_rating.comment_id', '=', 'tbl_comment.comment_id')->get();
        $comment_rep = Comment::with('book')->whereNotNull('comment_parent_comment')->get();
        $output = '';

        foreach($comment as $key => $comm){
            $rating = $comm->rating;
            
                $output .= '<div class="media mb-4">
                            <img src="'.url('/public/frontend/img/avatar-icon.png').'" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6>'.$comm->comment_name.'<small> - <i>'.$comm->comment_date.'</i></small></h6>';
                        if (!is_null($rating)) {
                            $fullStars = floor($rating);
                            $emptyStars = 5 - $fullStars;
                $output .= '<div class="text-danger mb-2">';
                            for ($i = 0; $i < $fullStars; $i++) {
                                $output .= '<i class="fas fa-star"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                $output .= '<i class="far fa-star"></i>';
                            }   
                $output .= '</div>';
            }
            $output .= ' <p>'.$comm->comment_info.'</p>
                        </div>
                    </div>';
                foreach($comment_rep as $key => $rep_comm){
                    if($rep_comm->comment_parent_comment == $comm->comment_id){
                        $output .= '<div class="media mb-4" style="margin:5px 60px">
                            <img src="'.url('/public/frontend/img/logo_mascot.jpg').'" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6 style="color: blue;">'.$rep_comm->comment_name.'<small> - <i>'.$rep_comm->comment_date.'</i></small></h6>
                                <p>'.$rep_comm->comment_info.'</p>
                            </div>
                        </div>
                    ';
                }
            }
        }
        echo $output;
    }

    public function send_comment(Request $request){
        $book_id = $request->book_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $rating = $request->rating;

        $comment = new Comment();
        $comment->comment_info = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_book_id = $book_id;
        $comment->save();

        if ($rating) {
            $new_rating = new Rating();
            $new_rating->book_id = $book_id;
            $new_rating->comment_id = $comment->comment_id;
            $new_rating->rating = $rating;
            $new_rating->save();
        }
    }

    public function list_comment(){
        $comment = Comment::with('book')->where('comment_parent_comment',null)->orderBy('comment_status', 'ASC')->get();
        $comment_rep = Comment::with('book')->whereNotNull('comment_parent_comment')->get();
        return view('admin.comment.list_comment')->with(compact('comment','comment_rep'));
    }

    public function allow_comment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }

    public function reply_comment(Request $request){
        $data = $request->all();
        $comment = new Comment;

        $comment->comment_info = $data['comment'];
        $comment->comment_book_id = $data['comment_book_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 1;
        $comment->comment_name = 'Cửa hàng sách Fahasa';
        $comment->save();
    }

    public function list_reply_comment($comment_id){
        $comment = Comment::with('book')->where('comment_id', $comment_id)->first();
        $comment_rep = Comment::with('book')->where('comment_parent_comment',$comment_id)->get();
        return view('admin.comment.comment_rep')->with(compact('comment', 'comment_rep', 'comment_id'));
    }

    public function delete_comment($comment_id){
        $comment = Comment::find($comment_id);

        if ($comment) {
            if ($comment->comment_parent_comment == null) {
                Comment::where('comment_parent_comment', $comment_id)->delete();
            }
            $comment->delete();

            return redirect()->back()->with('message', 'Xóa bình luận thành công!');
        } else {
            return redirect()->back()->with('error', 'Bình luận không tồn tại!');
        }
    }

}
