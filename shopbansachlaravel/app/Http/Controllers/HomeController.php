<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Banner;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request){
        $meta_desc = "Nhà sách Fahasa - Tích Điểm Khách Hàng Thân Thiết Không GiớI Hạn, Cùng Chương Trình Độc Quyền Cho Thành Viên.";
        $meta_keywords = "fahasa,nha sach fahasa,nhà sách fahasa,cửa hàng sách fahasa,sach,sách,trực tuyến,sach online,sách online";
        $meta_title = "Cửa hàng sách Fahasa - Nhà sách trực tuyến hàng đầu VN";
        $url_canonical = $request->url();

        $banner = Banner::orderby('banner_id','desc')->where('banner_status','1')->take(4)->get();

        $categories = DB::table('tbl_category_product')->leftJoin('tbl_book', 'tbl_category_product.category_id', '=', 'tbl_book.category_id')
        ->select(
            'tbl_category_product.category_id',
            'tbl_category_product.category_name',
            'tbl_category_product.category_image',
            DB::raw('COALESCE(SUM(tbl_book.book_quantity), 0) as total_quantity') // Tính tổng book_quantity, nếu null thì mặc định 0
        )
        ->groupBy('tbl_category_product.category_id', 'tbl_category_product.category_name', 'tbl_category_product.category_image')
        ->limit(10)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_parent', 0)->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $all_book = DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->paginate(15);

        foreach ($all_book as $book) {
            $rating = Rating::where('book_id', $book->book_id)->avg('rating');
            $book->avgRating = $rating !== null ? round($rating, 1) : 0;
            $book->totalreview = Rating::where('book_id', $book->book_id)->count();
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('pages.book.book_paginate', compact('all_book', 'categories', 'banner', 'cate_product', 'author', 'publisher'))->render(),
                'pagination' => (string) $all_book->links('vendor.pagination.custom')
            ]);
        }
        return view('pages.home')->with('category',$cate_product)->with('author',$author)->with('publisher',$publisher)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('all_book',$all_book)->with('banner',$banner)->with('categories',$categories);
    }

    public function tim_kiem(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $keywords = $request->keywords_submit;
        $search_book = DB::table('tbl_book')->where('book_status','1')->where('book_name','like','%'.$keywords.'%')->paginate(10);

        $meta_desc = "Hiển thị thông tin về đầu sách hoặc sản phẩm được tìm kiếm.";
        $meta_keywords = "tim kiem,tìm kiếm,tim kiem sach,tìm kiếm sách,fahasa";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        foreach ($search_book as $book) {
            $rating = Rating::where('book_id', $book->book_id)->avg('rating');
            $book->avgRating = $rating !== null ? round($rating, 1) : 0;
            $book->totalreview = Rating::where('book_id', $book->book_id)->count();
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('pages.book.search_paginate', compact('search_book', 'cate_product', 'author', 'publisher', 'keywords'))->render(),
                'pagination' => (string) $search_book->links('vendor.pagination.custom')
            ]);
        }
        return view('pages.book.search_book')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('search_book',$search_book)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
    
    public function autocomplete_search(Request $request){
    if ($request->ajax()) {
        $query = $request->input('query');

        if ($query) {
            $books = Book::where('book_status', 1)
                ->where('book_name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();

            $html = '<ul class="dropdown-menu" style="display:block; position:absolute; z-index:1000; width:100%;">';

            if ($books->isEmpty()) {
                $html .= '<li class="dropdown-item text-danger">Không tìm thấy sách</li>';
            } else {
                foreach ($books as $book) {
                    $shortName = Str::limit(e($book->book_name), 40, '...');
                    $html .= '<li class="dropdown-item search-item" data-fullname="'. e($book->book_name) .'">' 
                             . $shortName . 
                             '</li>';
                }
            }
            $html .= '</ul>';

            return response()->json(['html' => $html]);
            }
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function view_account(Request $request){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        if (!Session::has('previous_url')) {
            Session::put('previous_url', url()->previous());
        }
        $customer_id = Session::get('customer_id');
        $customer = DB::table('tbl_customer')->where('customer_id', $customer_id)->first();
        $shipping = DB::table('tbl_shipping')->where('customer_id', $customer_id)->first();

        $meta_desc = "Cung cấp thông tin về tài khoản bạn đã đăng ký. Bạn còn có thể chỉnh sửa thông tin vận chuyển tại đây hoặc trước mỗi lúc xác nhận thanh toán.";
        $meta_keywords = "thong tin tai khoan,thông tin tài khoản,tai khoan khach hang,tài khoản khách hàng,tai khoan,tài khoản,fahasa";
        $meta_title = "Thông tin tài khoản khách hàng của bạn";
        $url_canonical = $request->url();
        return view('pages.account.show_account')->with('category',$category)->with('author',$author)
        ->with('publisher',$publisher)->with('customer',$customer)->with('shipping',$shipping)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }

    public function update_user_account(Request $request){
        $customer_id = Session::get('customer_id');
        DB::table('tbl_customer')
        ->where('customer_id', $customer_id)
        ->update([
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
        ]);

        return redirect()->back()->with('message', 'Thông tin tài khoản đã được cập nhật!');
    }

    public function update_user_shipping(Request $request){
        $customer_id = Session::get('customer_id');
        $shipping_name = $request->input('shipping_name');
        $shipping_email = $request->input('shipping_email');
        $shipping_phone = $request->input('shipping_phone');
        $shipping_address = $request->input('shipping_address');

        DB::table('tbl_shipping')
            ->where('customer_id', $customer_id)
            ->update([
                'shipping_name' => $shipping_name,
                'shipping_email' => $shipping_email,
                'shipping_phone' => $shipping_phone,
                'shipping_address' => $shipping_address
            ]);
        return redirect()->back()->with('message', 'Cập nhật thông tin vận chuyển thành công!');
    }

}